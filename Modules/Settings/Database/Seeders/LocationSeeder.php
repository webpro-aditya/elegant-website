<?php

namespace Modules\Settings\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Settings\Entities\City;
use Modules\Settings\Entities\Country;
use Modules\Settings\Entities\State;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::truncate();
        $countries = json_decode(file_get_contents(resource_path('json/countries.json')));

        foreach ($countries as $country) {
            if (isset($country->short_name) && $country->short_name) {
                Country::create([
                    'iso2' => $country->iso2,
                    'iso3' => $country->iso3,
                    'short_name' => $country->short_name,
                    'long_name' => $country->long_name,
                    'status' => 1,
                    'country_code' => $country->country_code,
                ]);
            }
        }

        State::truncate();
        $states = json_decode(file_get_contents(resource_path('json/states.json')));

        foreach ($states as $state) {
            State::create([
                'name' => $state->name,
                'country_id' => $state->country_id,
                'state_code' => $state->state_code,
                'type' => $state->type,
                'latitude' => $state->latitude,
                'longitude' => $state->longitude,
                'status' => 1,
            ]);
        }

        City::truncate();
        $cities = json_decode(file_get_contents(resource_path('json/cities.json')));

        foreach ($cities as $city) {
            $state = State::where('state_code', $city->state_code)->first();
            City::create([
                'name' => $city->name,
                'state_id' => $state->id,
                'country_id' => $state->country_id,
            ]);
        }
    }
}
