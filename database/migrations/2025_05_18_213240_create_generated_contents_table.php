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
        Schema::create('generated_contents', function (Blueprint $table) {
            $table->id();
            $table->string('campaign_goal')->nullable();
            $table->text('briefing')->nullable(); // Aangepast naar nullable voor flexibiliteit
            $table->text('ai_headline')->nullable();
            $table->text('ai_subtext')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generated_contents');
    }
};