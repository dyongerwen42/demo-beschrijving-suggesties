<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product; // Zorg ervoor dat Product model geïmporteerd is
use Illuminate\Http\Request; // Kan blijven staan voor eventueel toekomstig gebruik
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log; // Voeg de Log facade toe

class ProductController extends Controller
{
    /**
     * Haal producten op voor een gegeven categorie die een AI-verbeterde beschrijving hebben.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function getProductsWithAiDescriptionByCategory(Category $category): JsonResponse
    {
        // Loggen dat de methode is aangeroepen en met welke categorie
        // De properties van $category zijn beschikbaar omdat Route Model Binding de categorie al heeft opgehaald
        Log::info("[ProductController] Methode getProductsWithAiDescriptionByCategory aangeroepen.");
        Log::info("[ProductController] Categorie ID: {$category->id}, Naam: {$category->name}, Slug: {$category->slug}");

        // De query om producten te filteren
        $products = $category->products()
            ->whereNotNull('ai_enhanced_description')
            ->where('ai_enhanced_description', '!=', '')
            ->get();

        // Loggen hoeveel producten er zijn gevonden
        Log::info("[ProductController] Aantal producten gevonden voor categorie '{$category->name}' met AI beschrijving: " . $products->count());

        if ($products->isEmpty()) {
            // Loggen dat er geen producten zijn gevonden en een 404 JSON response wordt teruggestuurd
            Log::warning("[ProductController] Geen producten gevonden voor categorie '{$category->name}' (ID: {$category->id}) die voldoen aan de criteria. Retourneert 404 JSON response.");
            return response()->json([
                'message' => 'No products found in this category with an AI-enhanced description.',
                'category_id' => $category->id,
                'category_name' => $category->name,
                'data' => []
            ], 404);
        }

        // Loggen dat producten succesvol worden geretourneerd
        Log::info("[ProductController] Retourneert {$products->count()} producten voor categorie '{$category->name}' (ID: {$category->id}).");
        return response()->json([
            'message' => 'Products with AI-enhanced descriptions retrieved successfully.',
            'category_id' => $category->id,
            'category_name' => $category->name,
            'data' => $products
        ]);
    }
}