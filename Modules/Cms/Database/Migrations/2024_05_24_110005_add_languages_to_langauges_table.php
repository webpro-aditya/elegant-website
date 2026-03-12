<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cms\Entities\Language;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $languages = [
            ['name' => 'ENGLISH', 'code' => 'en'],
            ['name' => 'ARABIC' , 'code' => 'ar'],
            ['name' => 'SPANISH' , 'code' => 'sp'],
            ['name' => 'FRENCH' , 'code' => 'fr'],
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(['name' => $language['name'], 'code'=>$language['code']]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $languages = [
            ['name' => 'ENGLISH'],
            ['name' => 'ARABIC'],
            ['name' => 'SPANISH'],
            ['name' => 'FRENCH'],
        ];

        foreach ($languages as $language) {
            Language::where('name', $language)->delete();
        }
    }
};
