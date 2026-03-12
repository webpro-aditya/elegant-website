<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Settings\Entities\Setting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Setting::create(['key' => 'en', 'value' => 'default', 'category' => 'store']);
        Setting::create(['key' => 'ar', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'sp', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'fr', 'value' => '', 'category' => 'store']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::where('key', 'en')->delete();
        Setting::where('key', 'ar')->delete();
        Setting::where('key', 'sp')->delete();
        Setting::where('key', 'fr')->delete();
    }
};
