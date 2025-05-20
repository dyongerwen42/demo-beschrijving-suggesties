<?php

namespace App\Services;

use OpenAI;
use OpenAI\Client; // Ensure this is the correct namespace for your installed package
use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Exceptions\UnserializableResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class AISuggestionService
{
    protected ?Client $client = null;
    protected string $openAiModel;
    protected bool $isClientInitialized = false;

    public function __construct()
    {
        $this->openAiModel = config('services.openai.model', env('OPENAI_MODEL', 'gpt-4o-mini'));
        $apiKey = config('services.openai.api_key', env('OPENAI_API_KEY'));

        if (empty($apiKey)) {
            Log::warning('OpenAI API key is not configured. AISuggestionService will be non-functional.');
            return;
        }

        try {
            $this->client = OpenAI::client($apiKey);
            $this->isClientInitialized = true;
        } catch (Throwable $e) {
            Log::error('Failed to initialize OpenAI client in AISuggestionService: ' . $e->getMessage(), [
                'exception' => $e
            ]);
        }
    }

    public function getSuggestions(?string $contextOrGoal, string $textToProcess, string $instruction = "Herschrijf de volgende tekst"): array
    {
        if (!$this->isClientInitialized || !$this->client) {
            return $this->formatErrorResponse('OpenAI client niet geïnitialiseerd. Controleer API sleutel en logs.');
        }

        if (empty($textToProcess)) {
            return $this->formatErrorResponse('Tekst om te verwerken is vereist.');
        }

        $prompt = "Je bent een expert marketing copywriter. Herschrijf de volgende productbeschrijving op basis van de gegeven instructie.\n\n";
        $prompt .= "Instructie voor herschrijven: " . htmlspecialchars($instruction, ENT_QUOTES, 'UTF-8') . "\n";
        if ($contextOrGoal && $contextOrGoal !== 'beschrijving_verbeteren') {
            $prompt .= "Context/Doel: " . htmlspecialchars($contextOrGoal, ENT_QUOTES, 'UTF-8') . "\n";
        }
        $prompt .= "Originele productbeschrijving om te herschrijven:\n\"" . htmlspecialchars($textToProcess, ENT_QUOTES, 'UTF-8') . "\"\n\n";
        $prompt .= "Geef je antwoord als een JSON object met één sleutel: \"rewritten_description\" (een string voor de herschreven beschrijving). Zorg dat de tekst direct bruikbaar is en de kern van het product behoudt, tenzij anders geïnstrueerd.";

        try {
            // MODIFIED LINE: Removed ->completions()
            $response = $this->client->chat()->create([
                'model' => $this->openAiModel,
                'response_format' => ['type' => 'json_object'],
                'messages' => [
                    ['role' => 'system', 'content' => 'Je bent een behulpzame marketing copywriter die output geeft in JSON formaat. Je bent beknopt, creatief en volgt de gegeven instructies nauwkeurig.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 400,
                'temperature' => 0.7,
            ]);

            $jsonOutput = $response->choices[0]->message->content;
            $suggestions = json_decode($jsonOutput, true);

            if (json_last_error() === JSON_ERROR_NONE && isset($suggestions['rewritten_description'])) {
                return [
                    'rewritten_description' => $suggestions['rewritten_description'],
                    'error' => false,
                    'error_message' => null,
                ];
            }

            Log::error('OpenAI JSON parsing error or unexpected structure for rewritten_description. Raw content: ' . $jsonOutput, [
                'context_or_goal' => $contextOrGoal,
                'last_json_error' => json_last_error_msg()
            ]);
            return $this->formatErrorResponse('Onverwachte data structuur van AI ontvangen.');

        } catch (TransporterException $e) {
            Log::error('OpenAI API TransporterException', ['message' => $e->getMessage(), 'context_or_goal' => $contextOrGoal]);
            return $this->formatErrorResponse('Kon geen verbinding maken met de AI-service.');
        } catch (UnserializableResponse $e) {
            Log::error('OpenAI API UnserializableResponse', ['message' => $e->getMessage(), 'context_or_goal' => $contextOrGoal]);
            return $this->formatErrorResponse('Onverwachte (onleesbare) respons van de AI-service.');
        } catch (ErrorException $e) {
            Log::error('OpenAI API ErrorException', ['message' => $e->getMessage(), 'type' => $e->type(), 'code' => $e->code(), 'param' => $e->param(), 'context_or_goal' => $contextOrGoal]);
            return $this->handleOpenAiErrorException($e);
        } catch (Throwable $e) {
            Log::error('Algemene fout bij OpenAI aanroep', ['message' => $e->getMessage(), 'context_or_goal' => $contextOrGoal, 'trace' => $e->getTraceAsString()]); // Added trace for general errors
            return $this->formatErrorResponse('Een onbekende fout is opgetreden bij de AI-service.');
        }
    }

    protected function buildPrompt(string $campaignGoal, string $briefing): string
    {
        $prompt = "Je bent een creatieve marketingassistent. Genereer een pakkende kopregel (maximaal 10 woorden) en een korte, wervende subtekst (maximaal 25 woorden) voor een marketingcampagne.\n\n";
        $prompt .= "Campagnedoel: " . htmlspecialchars($campaignGoal, ENT_QUOTES, 'UTF-8') . "\n";
        $prompt .= "Briefing van de gebruiker: " . htmlspecialchars($briefing, ENT_QUOTES, 'UTF-8') . "\n\n";
        $prompt .= "Geef je antwoord als een JSON object met twee sleutels: \"headline\" (een string voor de kopregel) en \"subtext\" (een string voor de subtekst). Zorg dat de tekst direct bruikbaar is.";
        return $prompt;
    }

    protected function formatErrorResponse(string $specificMessage): array
    {
        return [
            'rewritten_description' => null,
            'error' => true,
            'error_message' => $specificMessage,
        ];
    }

    protected function handleOpenAiErrorException(ErrorException $e): array
    {
        $subtextMessage = 'Er is een fout opgetreden bij de AI-service.';
        $apiErrorCode = $e->code();
        $apiErrorType = $e->type();

        if (str_contains(strtolower($e->getMessage()), 'quota') || $apiErrorType === 'insufficient_quota') {
            $subtextMessage = 'AI-service quota overschreden.';
        } elseif (str_contains(strtolower($e->getMessage()), 'key') || $apiErrorCode === 'invalid_api_key' || $apiErrorType === 'authentication_error') {
            $subtextMessage = 'AI-service API-sleutel is ongeldig of ontbreekt.';
        } elseif ($apiErrorCode === 'model_not_found' || (is_string($apiErrorType) && str_contains($apiErrorType, 'model_not_found'))) {
            $subtextMessage = 'Het geconfigureerde AI-model is niet gevonden.';
        }
        
        return $this->formatErrorResponse($subtextMessage);
    }
}