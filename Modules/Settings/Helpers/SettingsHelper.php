<?php

namespace Modules\Settings\Helpers;

use Modules\Cms\Entities\Language;
use Modules\Settings\Entities\City;
use Modules\Settings\Entities\Country;
use Modules\Settings\Entities\Currency;
use Modules\Settings\Entities\Setting;
use Modules\Settings\Entities\State;
use Modules\Settings\Entities\Timezone;

class SettingsHelper
{
    public function getAll()
    {
        $settings = Setting::get();

        return $settings;
    }

    public function settingsIn($keys)
    {
        return Setting::whereIn('key', $keys)->get();
    }

    public function getByKey($key)
    {
        return Setting::where('key', $key)->first();
    }

    public function getByKeys($keys)
    {
        return Setting::whereIn('key', $keys)->get();
    }

    public function getByCategories($categories)
    {
        $allSettings = Setting::whereIn('category', $categories)->get();
        $settingsArray = [];

        foreach ($allSettings as $setting) {
            $settingsArray[$setting->category][$setting->key] = $setting->value;
        }

        return $settingsArray;
    }

    public function update(array $input)
    {
        foreach ($input as $key => $value) {
            $setting = Setting::where('key', $key)->first();

            if (!empty($setting)) {
                $setting->value = $value;
                $setting->save();
                cache()->forget('settings'); //To reflect the settings immediately
            }
        }

        return $this->settingsIn(array_keys($input));
    }

    public function resetValue($setting)
    {
        if (is_string($setting)) {
            $setting = Setting::where('key', $setting)->first();
        }

        if (!empty($setting)) {
            $setting->value = '';
            $setting->save();
            cache()->forget('settings'); //To reflect the settings immediately
        }
    }

    public function setValueAsArray($setting, $data)
    {
        if (is_string($setting)) {
            $setting = Setting::where('key', $setting)->first();
        }

        if (!empty($setting)) {
            $setting->valueArray = $data;
            $setting->save();
            cache()->forget('settings'); //To reflect the settings immediately
        }
    }

    public function getKeyValue()
    {
        return Setting::select('key', 'value')->get()->mapWithKeys(function ($item) {
            return [$item['key'] => $item['value']];
        });
    }

    public function searchTimezones($keyword)
    {
        $timezones = Timezone::where('name', 'like', "%{$keyword}%");

        return $timezones->paginate(30, ['*'], 'page', request()->get('page'));
    }

    public function getTimezoneByTimezone($timezone)
    {
        return Timezone::where('timezone', $timezone)->first();
    }

    public function searchCountry($keyword)
    {
        $countries = Country::where('short_name', 'like', "%{$keyword}%");

        return $countries->paginate(30, ['*'], 'page', request()->get('page'));
    }

    public function getCountry($countryId)
    {
        return Country::find($countryId);
    }

    public function searchCurrency($keyword)
    {
        return Currency::where('name', 'like', "%{$keyword}%")->paginate(30, ['*'], 'page', request()->get('page'));
    }

    public function getCurrency($id)
    {
        return Currency::find($id);
    }

    public function getCountryCodes($keyword)
    {
        $countries = Country::where('short_name', 'like', "%{$keyword}%");

        return $countries->paginate(30, ['*'], 'page', request()->get('page'));
    }

    public function getCodes()
    {
        return Country::pluck('country_code');
    }


    public function searchState($keyword, $countryId)
    {
        $states = State::where('name', 'like', "%{$keyword}%");

        if ($countryId) {
            $states->where('country_id', $countryId);
        }

        return $states->paginate(30, ['*'], 'page', request()->get('page'));
    }

    public function getState($stateId)
    {
        return State::find($stateId);
    }

    public function searchCities($keyword, $stateId, $countryId)
    {
        $cities = City::where('name', 'like', "%{$keyword}%");

        if ($countryId) {
            $cities->where('country_id', $countryId);
        }

        if ($stateId) {
            $cities->where('state_id', $stateId);
        }

        return $cities->paginate(30, ['*'], 'page', request()->get('page'));
    }

    public function getCity($cityId)
    {
        return City::find($cityId);
    }
    public function getLanguages()
    {
        $languages = Language::all()->keyBy('id')->toArray();
        
        $settings = Setting::where('category', 'store')->pluck('value', 'key')->toArray();
        
        $availableLanguages = [];
        
        // Check if English is available, if so, add it to the beginning
        if (isset($languages[1])) {
            $availableLanguages[1] = $languages[1]['code']; // Add English with ID 1
            unset($languages[1]); // Remove English from the original languages array
        }
        
        // Add other available languages
        foreach ($languages as $id => $language) {
            $code = $language['code'];
            if (isset($settings[$code]) && $settings[$code] === 'checked') {
                $availableLanguages[$id] = $language['code'];
            }
        }
        return $availableLanguages;
    }


    public function getAllCountry()
    {
        $country = Country::where('status', 1)->get();

        return $country;
    }
    
    
}
