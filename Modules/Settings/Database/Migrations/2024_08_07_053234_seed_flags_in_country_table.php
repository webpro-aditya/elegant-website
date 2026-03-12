<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Settings\Database\Seeders\CountrySeeder;
use Modules\Settings\Entities\City;
use Modules\Settings\Entities\Country;
use Modules\Settings\Entities\State;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $seeder = new CountrySeeder();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        City::truncate();
        State::truncate();
        Country::truncate();
    }
};
