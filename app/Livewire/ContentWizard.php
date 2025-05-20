<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\AISuggestionService; // Ensure this use statement is present
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Illuminate\Support\Collection;

class ContentWizard extends Component
{
    use WithPagination;

    public int $currentStep = 1;

    // Stap 1: Category en Product Selectie
    public $availableCategories = [];
    public array $selectedCategoryIds = [];
    public array $selectedProductIdsForProcessing = [];
    public bool $toggleAllFiltered = false;
    public int $totalProductsInFilter = 0;

    // Stap 2: AI Instructie
    public string $rewriteInstruction = '';
    public array $tonePresets = [];

    // Stap 3: AI Resultaten
    public array $aiProcessedProducts = [];

    // REMOVED: protected AISuggestionService $aiService; // This was the source of the initialization error

    public function mount(/* REMOVED: AISuggestionService $aiServiceInstance */): void
    {
        // REMOVED: $this->aiService = $aiServiceInstance; // Service will be resolved when needed
        $this->availableCategories = Category::orderBy('name')->get()->toArray();
        $this->updateTotalProductsInFilter();

        $this->tonePresets = [
            'Wervend en overtuigend',
            'Formeel en professioneel',
            'Informeel en speels (met emojis)',
            'Kort, bondig en to-the-point',
            'Focus op unieke verkoopargumenten (USP\'s)',
            'Benadruk duurzaamheid en ethische aspecten',
            'Technisch en gedetailleerd voor experts',
            'Verhalend en sfeervol (storytelling)',
            'SEO-geoptimaliseerd met focus op keywords [keywords hier]',
            'Luxe en exclusief',
        ];
    }

    protected function rules(): array
    {
        return match ($this->currentStep) {
            1 => [],
            2 => [
                'rewriteInstruction' => 'required|string|max:500',
            ],
            default => [],
        };
    }

    protected array $validationAttributes = [
        'selectedProductIdsForProcessing' => 'te verwerken producten',
        'rewriteInstruction' => 'AI herschrijf-instructie',
    ];

    private function updateTotalProductsInFilter(): void
    {
        if (empty($this->selectedCategoryIds)) {
            $this->totalProductsInFilter = 0;
        } else {
            $categoryIds = array_map('intval', $this->selectedCategoryIds);
            $this->totalProductsInFilter = Product::query()
                ->whereIn('category_id', $categoryIds)
                ->count();
        }
    }

    public function updatedSelectedCategoryIds(): void
    {
        $this->resetPage('productsPage');
        $this->selectedProductIdsForProcessing = [];
        $this->toggleAllFiltered = false;
        $this->updateTotalProductsInFilter();
    }
    
    private function getAllProductIdsForCurrentFilter(): Collection
    {
        if (empty($this->selectedCategoryIds)) {
            return collect();
        }
        $categoryIds = array_map('intval', $this->selectedCategoryIds);
        return Product::query()
            ->whereIn('category_id', $categoryIds)
            ->pluck('id')
            ->map(fn($id) => (string)$id);
    }

    public function updatedToggleAllFiltered(bool $value): void
    {
        $allIdsInFilter = $this->getAllProductIdsForCurrentFilter()->all();

        if ($value) {
            $this->selectedProductIdsForProcessing = collect($this->selectedProductIdsForProcessing)
                ->merge($allIdsInFilter)
                ->unique()
                ->values()
                ->all();
        } else {
            $this->selectedProductIdsForProcessing = collect($this->selectedProductIdsForProcessing)
                ->reject(fn($id) => in_array($id, $allIdsInFilter))
                ->values()
                ->all();
        }
    }

    public function updatedSelectedProductIdsForProcessing(): void
    {
        if (empty($this->selectedCategoryIds)) {
            $this->toggleAllFiltered = false;
            return;
        }

        $allIdsInFilter = $this->getAllProductIdsForCurrentFilter();
        if ($allIdsInFilter->isEmpty() || $this->totalProductsInFilter === 0) { 
            $this->toggleAllFiltered = false;
            return;
        }

        $selectedIdsCollection = collect($this->selectedProductIdsForProcessing);
        $allFilteredAreSelected = $allIdsInFilter->every(fn($id) => $selectedIdsCollection->contains($id));
        $countOfSelectedItemsInFilter = $selectedIdsCollection->intersect($allIdsInFilter)->count();

        if ($allFilteredAreSelected && $countOfSelectedItemsInFilter === $this->totalProductsInFilter && $this->totalProductsInFilter > 0) {
            $this->toggleAllFiltered = true;
        } else {
            $this->toggleAllFiltered = false;
        }
    }

    private function getProductsForSelection()
    {
        if (empty($this->selectedCategoryIds)) {
            return Product::whereRaw('0 = 1')->paginate(5, ['*'], 'productsPage');
        }

        $categoryIds = array_map('intval', $this->selectedCategoryIds);
        $query = Product::query()->whereIn('category_id', $categoryIds);

        return $query->with('category')->orderBy('name')->paginate(5, ['*'], 'productsPage');
    }

    public function render()
    {
        $fetchedProducts = $this->getProductsForSelection();
        return view('livewire.content-wizard', [
            'fetchedProducts' => $fetchedProducts
        ]);
    }

    public function nextStep(): void
    {
        if ($this->currentStep === 1) {
            if (empty($this->selectedProductIdsForProcessing)) {
                session()->flash('error', 'Selecteer tenminste één product om te verwerken.');
                $this->addError('selectedProductIdsForProcessing', 'Selecteer producten.');
                return;
            }
            $this->resetErrorBag('selectedProductIdsForProcessing');
        } elseif ($this->currentStep === 2) {
            $this->validateOnly('rewriteInstruction');
            $this->processProductsWithAI(); 
        }

        if ($this->currentStep < 3) {
            $this->currentStep++;
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function processProductsWithAI(): void
    {
        $aiService = app(AISuggestionService::class); // Resolve service here

        $this->aiProcessedProducts = [];
        if (empty($this->selectedProductIdsForProcessing)) {
            session()->flash('error', 'Geen producten geselecteerd voor AI verwerking.');
            return;
        }

        $productsToProcess = Product::whereIn('id', array_map('intval', $this->selectedProductIdsForProcessing))->get();

        if ($productsToProcess->isEmpty()) {
            session()->flash('error', 'Geselecteerde producten niet gevonden in de database.');
            return;
        }

        foreach ($productsToProcess as $product) {
            $result = $aiService->getSuggestions(
                'product_beschrijving',
                $product->description,
                $this->rewriteInstruction
            );

            // Updated to use the modified response structure from AISuggestionService
            $this->aiProcessedProducts[$product->id] = [
                'product_name' => $product->name,
                'original_description' => $product->description,
                'ai_suggestion' => $result['rewritten_description'] ?? (($result['error'] ?? false) ? 'Fout bij generatie' : 'Geen suggestie ontvangen'),
                'error' => $result['error'] ?? false,
                'error_message' => $result['error_message'] ?? null
            ];
        }
    }

    public function submitWizard(): void
    {
        if ($this->currentStep !== 3) {
            session()->flash('error', 'Doorloop eerst alle stappen van de wizard.');
            return;
        }

        if (empty($this->aiProcessedProducts)) {
            session()->flash('error', 'Geen producten verwerkt door AI om op te slaan.');
            return;
        }
        
        $savedCount = 0;
        $errorCount = 0;
        foreach ($this->aiProcessedProducts as $productId => $processedData) {
            if (!($processedData['error'] ?? false) && !empty($processedData['ai_suggestion'])) {
                try {
                    $productToUpdate = Product::find((int)$productId); 
                    if ($productToUpdate) { 
                        $productToUpdate->ai_enhanced_description = $processedData['ai_suggestion'];
                        $productToUpdate->save();
                        $savedCount++;
                    }
                } catch (\Exception $e) {
                    Log::error("Fout bij opslaan van AI beschrijving voor product ID {$productId}: " . $e->getMessage());
                    $errorCount++;
                }
            } elseif ($processedData['error'] ?? false) {
                $errorCount++;
            }
        }

        if ($savedCount > 0) {
            session()->flash('message', $savedCount . ' productbeschrijving(en) succesvol bijgewerkt!');
        }
        if ($errorCount > 0) {
              session()->flash('error', $errorCount . ' productbeschrijving(en) konden niet worden opgeslagen of AI verwerking mislukte.');
        }
        if ($savedCount === 0 && $errorCount === 0 && !empty($this->aiProcessedProducts)) {
            session()->flash('info', 'Geen wijzigingen om op te slaan of alle AI verwerkingen resulteerden in lege suggesties.');
        }
        
        $this->resetWizard();
    }

    public function resetWizard(): void
    {
        $this->reset([
            'currentStep',
            'selectedCategoryIds',
            'selectedProductIdsForProcessing',
            'rewriteInstruction',
            'aiProcessedProducts',
            'toggleAllFiltered',
        ]);
        $this->totalProductsInFilter = 0;
        
        $this->currentStep = 1;
        $this->resetErrorBag();
        $this->resetPage('productsPage');
        session()->forget(['message', 'error', 'info']);
    }
}