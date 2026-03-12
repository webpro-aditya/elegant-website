<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Settings\Entities\Setting;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Setting::create(['key' => 'company_name', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'company_description', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'fav_icon', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'logo_dark', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'logo_light', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'address', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'email', 'value' => '', 'category' => 'store']);
        Setting::create(['key' => 'phone', 'value' => '', 'category' => 'store']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Setting::where('key', 'company_name')->delete();
        Setting::where('key', 'company_description')->delete();
        Setting::where('key', 'fav_icon')->delete();
        Setting::where('key', 'logo_dark')->delete();
        Setting::where('key', 'logo_light')->delete();
        Setting::where('key', 'email')->delete();
        Setting::where('key', 'phone')->delete();
    }
};
