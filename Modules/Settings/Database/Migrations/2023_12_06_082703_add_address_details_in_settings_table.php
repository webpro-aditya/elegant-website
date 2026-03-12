<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Settings\Entities\Setting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Setting::create(['key' => 'company_address_line1', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'company_address_line2', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'company_city', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'company_postel_code', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'company_city_id', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'company_state_id', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'company_country_id', 'value' => '238', 'category' => 'store']);
        Setting::create(['key' => 'facebook_url', 'value' => '', 'category' => 'social']);
        Setting::create(['key' => 'twitter_url', 'value' => '', 'category' => 'social']);
        Setting::create(['key' => 'youtube_url', 'value' => '', 'category' => 'social']);
        Setting::create(['key' => 'instagram_url', 'value' => '', 'category' => 'social']);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Setting::where('key', 'company_address_line1')->delete();
        Setting::where('key', 'company_address_line2')->delete();
        Setting::where('key', 'company_city')->delete();
        Setting::where('key', 'company_postel_code')->delete();
        Setting::where('key', 'company_city_id')->delete();
        Setting::where('key', 'company_state_id')->delete();
        Setting::where('key', 'company_country_id')->delete();
        Setting::where('key', 'facebook_url')->delete();
        Setting::where('key', 'twitter_url')->delete();
        Setting::where('key', 'youtube_url')->delete();
        Setting::where('key', 'instagram_url')->delete();
    }
};
