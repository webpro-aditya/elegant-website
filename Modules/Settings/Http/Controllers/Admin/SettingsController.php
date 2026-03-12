<?php

namespace Modules\Settings\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Settings\Helpers\SettingsHelper;
use Modules\Settings\Http\Requests\Admin\SettingsUpdateRequest;
use Modules\Settings\Http\Requests\Admin\SettingsViewRequest;

class SettingsController extends Controller
{
    protected $settingsHelper;

    protected $countryHelper;

    public function __construct(SettingsHelper $settingsHelper)
    {
        $this->settingsHelper = $settingsHelper;
    }

    public function branding(SettingsViewRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Settings / Branding'],
        ];
        $settings = $this->settingsHelper->getAll()->keyBy('key');

        $old = [];

        if ($settings->get('company_city_id')->value) {
            $old['company_city_id'] = $this->settingsHelper->getState(old('company_city_id', $settings->get('company_state_id')->value));
        }

        if ($settings->get('company_state_id')->value) {
            $old['company_state_id'] = $this->settingsHelper->getState(old('company_state_id', $settings->get('company_state_id')->value));
        }

        $languages = $this->settingsHelper->getLanguages();

        return view('settings::branding', compact('settings', 'breadcrumbs', 'old', 'languages'));
    }

    public function seo(SettingsViewRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'admin_dashboard', 'name' => 'Dashboard'],
            ['name' => 'System / Store / SEO'],
        ];
        $settings = $this->settingsHelper->getAll()->keyBy('key');

        return view('settings::seo', compact('settings', 'breadcrumbs'));
    }

    public function configuration(SettingsViewRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Settings / Configuration'],
        ];
        $settings = $this->settingsHelper->getAll()->keyBy('key');
        $old = [];

        if ($settings->get('timezone')->value) {
            $old['timezone'] = $this->settingsHelper->getTimezoneByTimezone($settings->get('timezone')->value);
        }

        if ($settings->get('country_id')->value) {
            $old['country_id'] = $this->settingsHelper->getCountry($settings->get('country_id')->value);
        }

        if ($settings->get('currency_id')->value) {
            $old['currency_id'] = $this->settingsHelper->getCurrency($settings->get('currency_id')->value);
        }

        if ($settings->get('section')->value) {
            $old['section'] = $settings->get('section')->value;
        }

        return view('settings::configuration', compact('settings', 'breadcrumbs', 'old'));
    }

    public function socialSettings(SettingsViewRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Settings / Social Settings'],
        ];
        $settings = $this->settingsHelper->getAll()->keyBy('key');

        return view('settings::socialSettings', compact('settings', 'breadcrumbs'));
    }

    public function saveSettings(SettingsUpdateRequest $request)
    { 
        try {
            $saveData = $request->all();

            $settingsLanguages = ['ar', 'sp', 'fr'];

            // Initialize all languages as unchecked
            foreach ($settingsLanguages as $settingLanguage) {
                // Check if $saveData['language'] exists and if the current language is in it, if yes, mark it as checked, else leave it unchecked
                $saveData[$settingLanguage] = isset($saveData['language']) && in_array($settingLanguage, $saveData['language']) ? 'checked' : '';
            }
            if ($request->hasFile('fav_icon')) {
                $favIcon = $request->file('fav_icon');
                $favIconName = 'favicon.' . $favIcon->getClientOriginalExtension();
                $favIconPath = 'app';
                $file = Storage::disk('elegant')->putFileAs($favIconPath, $favIcon, $favIconName);
                $saveData['fav_icon'] = $file;
            } elseif ($request->has('fav_icon_remove') && $request->fav_icon_remove) {
                $saveData['fav_icon'] = '';
            }

            if ($request->hasFile('logo_light')) {
                $logo = $request->file('logo_light');
                $logoName = 'logo_light.' . $logo->getClientOriginalExtension();
                $logoPath = 'app';
                $file = Storage::disk('elegant')->putFileAs($logoPath, $logo, $logoName);
                $saveData['logo_light'] = $file;
            } elseif ($request->has('logo_light_remove') && $request->logo_light_remove) {
                $saveData['logo_light'] = '';
            }

            if ($request->hasFile('logo_dark')) {
                $logo = $request->file('logo_dark');
                $logoName = 'logo_dark.' . $logo->getClientOriginalExtension();
                $logoPath = 'app';
                $file = Storage::disk('elegant')->putFileAs($logoPath, $logo, $logoName);
                $saveData['logo_dark'] = $file;
            } elseif ($request->has('logo_dark_remove') && $request->logo_dark_remove) {
                $saveData['logo_dark'] = '';
            }



            if ($request->has('dateformat')) {
                $saveData['date_only_js'] = implode('', $request->dateformat);
                $saveData['date_only_display'] = implode('', $request->dateformat);
            }

            $this->settingsHelper->update($saveData);

            cache()->forget('settings');
            cache()->forget('service_settings');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    public function timezonesOptions(Request $request)
    {
        $term = trim($request->search);
        $timezones = $this->settingsHelper->searchTimezones($term);
        $timezonesOptions = [];

        foreach ($timezones as $timezone) {
            $timezonesOptions[] = ['id' => $timezone->timezone, 'text' => $timezone->name];
        }

        return response()->json($timezonesOptions);
    }

    public function countriesOptions(Request $request)
    {
        $term = trim($request->search);
        $countries = $this->settingsHelper->searchCountry($term);
        $countriesOptions = [];

        foreach ($countries as $country) {
            $countriesOptions[] = ['id' => $country->id, 'text' => $country->short_name];
        }

        return response()->json($countriesOptions);
    }

    public function countryCodesOptions(Request $request)
    {
        $term = trim($request->search);
        $countries = $this->settingsHelper->searchCountry($term);
        $countriesOptions = [];

        foreach ($countries as $country) {
            $countriesOptions[] = ['id' => $country->id, 'short_name' => $country->short_name, 'image' => asset('images/flags/' . $country->image), 'text' => '+' . $country->country_code . ' - ' . $country->short_name];
        }

        return response()->json($countriesOptions);
    }

    public function currenciesOptions(Request $request)
    {
        $term = trim($request->search);
        $currencies = $this->settingsHelper->searchCurrency($term);
        $currenciesOptions = [];

        foreach ($currencies as $currency) {
            $currenciesOptions[] = ['id' => $currency->id, 'text' => $currency->name . '-' . $currency->symbol];
        }

        return response()->json($currenciesOptions);
    }

    public function statesOptions(Request $request)
    {
        $term = trim($request->search);
        $countryId = ($request->has('country_id') && $request->country_id) ? $request->country_id : '';
        $states = $this->settingsHelper->searchState($term, $countryId);
        $statesOptions = [];

        foreach ($states as $state) {
            $statesOptions[] = ['id' => $state->id, 'text' => $state->name];
        }

        return response()->json($statesOptions);
    }

    public function citiesOptions(Request $request)
    {
        $term = trim($request->search);
        $stateId = ($request->has('state_id') && $request->state_id) ? $request->state_id : '';
        $countryId = ($request->has('country_id') && $request->country_id) ? $request->country_id : '';
        $cities = $this->settingsHelper->searchCities($term, $stateId, $countryId);
        $citiesOptions = [];

        foreach ($cities as $city) {
            $citiesOptions[] = ['id' => $city->id, 'text' => $city->name];
        }

        return response()->json($citiesOptions);
    }

    public function keySettings(SettingsViewRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Settings / Key Settings'],
        ];
        $settings = $this->settingsHelper->getAll()->keyBy('key');

        return view('settings::keySettings', compact('settings', 'breadcrumbs'));
    }

    public function codesOptions(Request $request)
    {
        $term = trim($request->search);
        $codes = $this->settingsHelper->getCountryCodes($term);
        $codesOptions = [];

        foreach ($codes as $country) {
            $codesOptions[] = ['id' => $country->country_code, 'text' => $country->country_code];
        }
        return response()->json($codesOptions);
    }

}
