<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Translation\Entities\Translation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Translation::updateOrCreate(
            ['key' => 'tech_learning'],
            [
                'value_en' => 'UAE’s Leading Vernacular Tech-Learning Channel',
                'value_ar' => 'قناة التعلم التكنولوجي العامية الرائدة في الإمارات'
            ]
        );
        Translation::where('key', 'training_calender')->update([
            'value_en' => 'Training Calendar',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optional: Revert back to India version
        Translation::updateOrCreate(
            ['key' => 'tech_learning'],
            [
                'value_en' => 'India’s Leading Vernacular Tech-Learning Channel',
                'value_ar' => 'قناة التعلم التكنولوجي العامية الرائدة في الهند'
            ]
        );
        Translation::where('key', 'training_calender')->update([
            'value_en' => 'Training Calender',
        ]);
    }
};
