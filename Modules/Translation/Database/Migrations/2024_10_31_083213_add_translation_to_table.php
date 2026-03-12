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
        $translations = [
            ['key' => 'lms', 'value_en' => 'LMS', 'value_ar' => 'LMS'],
        ];
        foreach ($translations as $translation) {
            Translation::create($translation);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Translation::truncate();
    }
};
