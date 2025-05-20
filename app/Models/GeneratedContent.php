<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_goal', // Dit veld wordt niet meer gebruikt in de nieuwe wizard-flow
        'briefing',      // Dit veld is in de nieuwe flow 'rewriteInstruction'
        'ai_headline',   // Dit wordt nu 'ai_enhanced_description' in het Product model
        'ai_subtext',    // Idem
    ];
}