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
            ['key' => 'our_esteemed_clients', 'value_en' => 'Our Esteemed Clients', 'value_ar' =>'عملائنا الكرام'];
        Translation::create($translations);
    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
    {
        Translation::where('key', 'our_esteemed_clients')->delete();
    }
};
