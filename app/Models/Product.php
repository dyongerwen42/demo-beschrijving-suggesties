<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Niet meer nodig als tags relatie weg is
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use LogicException; // For throwing exceptions
// use App\Models\Tag; // Tag model wordt niet meer gebruikt in dit model

class Product extends Model
{
    use HasFactory;

    // Eigenschappen gebruikt door de ProductFactory voor tag-verwerking zijn verwijderd
    // public $temporary_tags_for_factory; // Verwijderd
    // public $factory_in_progress_tags; // Verwijderd

    protected $fillable = [
        'category_id',
        'external_id',
        'name',
        'description',
        'ai_enhanced_description',
    ];

    /**
     * Definieert de relatie: een product behoort tot één categorie.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * De relatie voor tags is verwijderd.
     */
    // public function tags(): BelongsToMany
    // {
    //     return $this->belongsToMany(Tag::class, 'product_tag');
    // }

    /**
     * De "booted" methode van het model voor model events.
     */
    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            // Controleer of category_id is ingesteld en geldig is voordat het product wordt opgeslagen
            if (empty($product->category_id)) {
                if ($product->relationLoaded('category') && $product->category && $product->category->id) {
                    $product->category_id = $product->category->id;
                }
                
                if (empty($product->category_id)) {
                    $errorMessage = "Product (poging tot opslaan van '{$product->name}') mist een geldige category_id.";
                    Log::error($errorMessage); // Behoud logging voor kritieke fouten
                    throw new LogicException($errorMessage);
                }
            }
        });

        // De static::created hook die controleerde op tags en een waarschuwing logde, is verwijderd.
        // Dit voorkomt de waarschuwingen in je logs, aangezien het ontbreken van tags nu verwacht gedrag is.
    }
}