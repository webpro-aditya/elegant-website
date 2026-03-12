<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Settings\Entities\Setting;

return new class extends Migration
{
    public function up()
    {
        Setting::create(['key' => 'gst_number', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'state_id', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'city_id', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'zip_code', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'latitude', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'longitude', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'web_address', 'value' => '', 'category' => 'store']);
    }

    public function down()
    {
        Setting::where('key', 'gst_number')->delete();
        Setting::where('key', 'country_id')->delete();
        Setting::where('key', 'state_id')->delete();
        Setting::where('key', 'city_id')->delete();
        Setting::where('key', 'zip_code')->delete();
        Setting::where('key', 'latitude')->delete();
        Setting::where('key', 'longitude')->delete();
        Setting::where('key', 'web_address')->delete();
    }
};
