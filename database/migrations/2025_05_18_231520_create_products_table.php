<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Foreign key naar de 'categories' tabel. Moet NOT NULL zijn.
            $table->foreignId('category_id')
                  ->constrained('categories') // Verwijst naar 'id' op 'categories' tabel
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            
            $table->string('external_id')->unique()->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('ai_enhanced_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
