<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
// use App\Models\Tag; // Tag model wordt niet meer gebruikt
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Nog steeds nodig voor eventuele andere DB operaties
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Starting database seeding (DEBUG MODE - ProductFactory for categories ONLY)...'); // Aangepast bericht

        // Optioneel: Truncate tables
        // De vraag en de truncate-acties zijn aangepast om tag-tabellen niet meer te noemen
        if ($this->command->confirm('Do you wish to truncate product and category tables first?', true)) {
            $this->command->warn('Truncating product and category tables...');
            Schema::disableForeignKeyConstraints();
            // DB::table('product_tag')->truncate(); // Verwijderd: product_tag tabel is tag-gerelateerd
            Product::truncate();
            // Tag::truncate(); // Verwijderd: Tag model/tabel wordt niet meer gebruikt
            Category::truncate();
            Schema::enableForeignKeyConstraints();
            $this->command->info('Product and category tables truncated.');
        }

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $this->command->info('Test user created/updated.');

        $categoriesToSeed = ['Elektronica', 'Speelgoed', 'Mode'];
        foreach ($categoriesToSeed as $catName) {
            Category::firstOrCreate(
                ['slug' => Str::slug($catName)],
                ['name' => $catName, 'description' => "Producten in de categorie {$catName}"]
            );
        }
        $this->command->info(Category::count() . ' categories seeded/ensured.');
        if (Category::count() === 0) {
            $this->command->error('CRITICAL: No categories available. ProductFactory cannot assign category_id. Aborting product seed.');
            Log::critical('DatabaseSeeder: No categories found or seeded. ProductFactory will fail.');
            return;
        }

        $numberOfProductsToGenerate = 2000; // <-- ZEER LAAG AANTAL VOOR DEBUGGING
        // Bericht aangepast, geen "NO 'hasAttached'" meer relevant voor tags
        $this->command->info("Attempting to seed {$numberOfProductsToGenerate} products using ProductFactory...");

        if ($numberOfProductsToGenerate > 0) {
            try {
                Product::factory()
                    ->count($numberOfProductsToGenerate)
                    // ->hasAttached( ... ) // Deze methode is typisch voor relaties, was al uitgecommentarieerd
                    ->create();
                $this->command->info("Product::factory()->create() call completed for {$numberOfProductsToGenerate} products.");
            } catch (\Exception $e) {
                $this->command->error("EXCEPTION during Product::factory()->create() in Seeder: " . $e->getMessage());
                Log::error("EXCEPTION during Product::factory()->create() in Seeder: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            }
        }

        $this->command->info("--- Diagnostic Check: Category for factory-generated products ---"); // Titel aangepast
        $sampleProducts = Product::orderBy('id', 'desc')->take($numberOfProductsToGenerate)->get();

        if ($sampleProducts->isEmpty()) {
            $this->command->warn("Could not retrieve any sample products for diagnostic check. Were any products created by the factory?");
        } else {
            foreach ($sampleProducts as $sampleProduct) {
                $categoryNameText = $sampleProduct->category ? $sampleProduct->category->name : 'GEEN CATEGORIE OBJECT';
                // Tag-gerelateerde variabelen en controles verwijderd
                // $tagCount = $sampleProduct->tags()->count(); // Verwijderd
                // $tagNames = $tagCount > 0 ? $sampleProduct->tags()->pluck('name')->implode(', ') : '!!! GEEN TAGS GEKOPPELD !!!'; // Verwijderd

                $this->command->line("Product ID {$sampleProduct->id} ('{$sampleProduct->name}')");
                $this->command->line("  -> Categorie ID: {$sampleProduct->category_id} (Naam: [{$categoryNameText}])");
                // $this->command->line("  -> Tags Gekoppeld: [{$tagNames}] (Aantal: {$tagCount})"); // Verwijderd

                if (empty($sampleProduct->category_id)) {
                    $this->command->error("    ALARM: Product ID {$sampleProduct->id} has NO CATEGORY_ID assigned!");
                }
                // De waarschuwing voor geen tags is verwijderd, want dat is nu verwacht gedrag
                // if ($tagCount === 0) {
                //     $this->command->warn("    WAARSCHUWING: Product ID {$sampleProduct->id} has NO TAGS ATTACHED after factory processing.");
                // }
            }
        }
        $this->command->info("--- End of Diagnostic Check ---");
        $this->command->error('BELANGRIJK: Controleer nu storage/logs/laravel.log voor ProductFactory logs!'); // Deze is nog steeds relevant voor de factory
        $this->command->info('Database seeding (debug run, categories only) completed.'); // Aangepast bericht
    }
    // seedHeroProducts() is hier niet aangeroepen om de test geïsoleerd te houden.
}