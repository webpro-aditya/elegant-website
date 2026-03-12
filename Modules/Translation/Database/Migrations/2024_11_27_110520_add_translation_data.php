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
        $translations =
            ['key' => 'gallery', 'value_en' => 'Gallery', 'value_ar' => 'معرض'];
        Translation::create($translations);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Translation::where('key', 'gallery')->delete();
    }
    
};
