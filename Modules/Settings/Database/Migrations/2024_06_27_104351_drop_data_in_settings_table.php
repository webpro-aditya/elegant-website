<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cms\Entities\Language;
use Modules\Settings\Entities\Setting;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('language_id')->nullable()->index();
        });
        Setting::where('key', 'company_name')->delete();
        Setting::where('key', 'company_address_line1')->delete();
        Setting::where('key', 'company_city')->delete();
        Setting::where('key', 'company_address_line2')->delete();
        Setting::where('key', 'company_description')->delete();
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('language_id');
        });

        Setting::create(['key' => 'company_name', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'company_address_line1', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'company_city', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'company_address_line2', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'company_description', 'value' => '', 'category' => 'store']);
    }
};
