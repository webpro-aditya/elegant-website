<?php

// app/Providers/LocaleServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Cms\Entities\Language;
use Illuminate\Support\Facades\Schema;

class LocaleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if (Schema::hasTable('languages') && class_exists(Language::class)) {
            $languageIds = Language::whereIn('code', ['en', 'sp', 'fr', 'ar'])
                ->get()
                ->mapWithKeys(function ($language) {
                    return [$language->code => $language->id];
                })
                ->toArray();

            config(['app.local_languages' => $languageIds]);
        } else {
            config(['app.local_languages' => ['en' => 1]]);
        }
    }
}
