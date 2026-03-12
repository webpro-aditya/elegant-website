<?php

namespace Modules\Settings\Http\Controllers\Api;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->prefix('settings')->group(function () {
    Route::get('get', [SettingsController::class, 'getSettings']);
    Route::post('save', [SettingsController::class, 'saveSettings']);

    Route::prefix('options')->group(function () {
        Route::get('timezones', [SettingsController::class, 'timezonesOptions']);
        Route::get('countries', [SettingsController::class, 'countriesOptions']);
        Route::get('country_code', [SettingsController::class, 'countryCodesOptions']);
        Route::get('currencies', [SettingsController::class, 'currenciesOptions']);
        Route::get('states', [SettingsController::class, 'statesOptions']);
        Route::get('cities', [SettingsController::class, 'citiesOptions']);
    });
});
