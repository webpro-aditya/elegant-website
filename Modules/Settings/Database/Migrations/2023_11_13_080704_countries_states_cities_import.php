<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Settings\Database\Seeders\LocationSeeder;
use Modules\Settings\Entities\City;
use Modules\Settings\Entities\Country;
use Modules\Settings\Entities\State;

return new class extends Migration
{
    public function up()
    {
        $seeder = new LocationSeeder();
        $seeder->run();
    }

    public function down()
    {
        City::truncate();
        State::truncate();
        Country::truncate();
    }
};
