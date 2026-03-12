<?php

namespace Modules\Settings\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Settings management
 */
Route::middleware('auth:admin')->prefix('settings')->name('settings_')->group(function () {
    Route::prefix('branding')->name('branding_')->group(function () {
        Route::get('/', [SettingsController::class, 'branding'])->name('view');
    });
    Route::prefix('config')->name('config_')->group(function () {
        Route::get('/', [SettingsController::class, 'configuration'])->name('view');
    });
    Route::prefix('social')->name('social_')->group(function () {
        Route::get('/', [SettingsController::class, 'socialSettings'])->name('view');
    });
    Route::prefix('keys')->name('keys_')->group(function () {
        Route::get('/', [SettingsController::class, 'keySettings'])->name('view');
    });
    Route::prefix('seo')->name('seo_')->group(function () {
        Route::get('/', [SettingsController::class, 'seo'])->name('view');
    });
    Route::post('settings/save', [SettingsController::class, 'saveSettings'])->name('save_settings');
});

Route::get('country-options', [SettingsController::class, 'codesOptions'])->name('options_codes');

/**
 * Acitivity
 */
// Route::prefix('activity_log')->name('activity_log_')->group(function () {
//     Route::get('/', [ActivityController::class, 'listActivity'])->name('list');
//     Route::post('table', [ActivityController::class, 'activityListData'])->name('table');
// });

Route::prefix('options')->name('options_')->group(function () {
    Route::get('timezones', [SettingsController::class, 'timezonesOptions'])->name('timezones');
    Route::get('countries', [SettingsController::class, 'countriesOptions'])->name('countries');
    Route::get('country_code', [SettingsController::class, 'countryCodesOptions'])->name('country_code');
    Route::get('currencies', [SettingsController::class, 'currenciesOptions'])->name('currencies');
    Route::get('states', [SettingsController::class, 'statesOptions'])->name('states');
    Route::get('cities', [SettingsController::class, 'citiesOptions'])->name('cities');
});

Route::prefix('mail-template')->name('mail_template_')->group(function () {
    Route::get('/{id?}', [MailTemplateController::class, 'view'])->name('view');
    Route::post('update', [MailTemplateController::class, 'update'])->name('update');

});
