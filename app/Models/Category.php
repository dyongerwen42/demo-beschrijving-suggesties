<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory; // Maakt Category::factory() mogelijk

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Definieert de relatie: een categorie heeft meerdere producten.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}