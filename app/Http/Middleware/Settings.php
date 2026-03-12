<?php

namespace App\Http\Middleware;

use Closure;
use Modules\Settings\Helpers\SettingsHelper;

class Settings
{
    protected $settingsHelper;

    public function __construct(SettingsHelper $settingsHelper)
    {
        $this->settingsHelper = $settingsHelper;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * Load general settings to cache and remains for 5 min
         */
        $settings = cache()->remember('settings', 86400, function () {
            try {
                $settingsArray = $this->settingsHelper->getByCategories(['store', 'config', 'social']);
            } catch (\Exception $e) {
                $settingsArray = [];
            }

            return $settingsArray;
        });
        config()->set('settings', $settings);

        if (isset($settings['config']['timezone'])) {
            config()->set('app.timezone', $settings['config']['timezone']);
        }

        // if (isset($settings['config']['currency_id'])) {
        //     $currencyId = $settings['config']['currency_id'] ? $settings['config']['currency_id'] : 4;
        //     $currency = cache()->remember('currency', 86400, function () use ($currencyId) {
        //         return $this->currencyRepo->getCurrency($currencyId);
        //     });
        //     config()->set('app.currency', $currency->toArray());
        // }

        if (isset($settings['config']['date_only_js']) && isset($settings['config']['date_only_display']) && isset($settings['config']['date_only_store'])) {
            $dateFormat = [
                'date_only_js' => $settings['config']['date_only_js'],
                'date_only_display' => $settings['config']['date_only_display'],
                'date_only_store' => $settings['config']['date_only_store'],

                'time_only_js' => 'H:i',
                'time_only_display' => 'H:i',
                'time_only_store' => 'H:i',

                'date_time_js' => $settings['config']['date_only_js'] . ' H:i',
                'date_time_display' => $settings['config']['date_only_display'] . ' H:i',
                'date_time_store' => $settings['config']['date_only_store'] . ' H:i',

                'date_time_first_store' => $settings['config']['date_only_store'] . ' 00:00:00',
                'date_time_last_store' => $settings['config']['date_only_store'] . ' 23:59:59',

                'date_time_first_display' => $settings['config']['date_only_display'] . ' 00:00:00',
                'date_time_last_display' => $settings['config']['date_only_display'] . ' 23:59:59',

                'day_first' => 'Y-m-d 00:00:00',
                'day_last' => 'Y-m-d 23:59:59',

            ];
            config()->set('date_format', $dateFormat);
        }

        return $next($request);
    }
}
