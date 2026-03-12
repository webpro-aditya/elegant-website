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
        Setting::create(['key' => 'seo_title', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'google_analytics_head', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'google_analytics_body', 'value' => '', 'category' => 'store']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::where('key', 'seo_title')->delete();
        Setting::where('key', 'google_analytics_head')->delete();
        Setting::where('key', 'google_analytics_body')->delete();
    }
};
