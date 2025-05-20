<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ContentWizard; // Zorg dat het pad naar je component klopt
use App\Http\Controllers\Api\ProductController; // Importeer je API controller

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome'); // Dit is de standaard Laravel welkomstpagina
});

// Route voor de Content Wizard
Route::get('/content-wizard', ContentWizard::class)->name('content-wizard');

// API-achtige route in web.php voor testen (later beveiligen en eventueel verplaatsen naar api.php)
Route::get('/api/categories/{category}/products-with-ai-description', [ProductController::class, 'getProductsWithAiDescriptionByCategory'])
    ->name('web.api.categories.products.ai_description'); // Aangepaste naam om conflicten te voorkomen

// Hier kun je eventueel andere routes toevoegen die je later nodig hebt
// voor authenticatie, dashboards, etc. maar voor de wizard zelf is bovenstaande genoeg.