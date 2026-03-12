<?php

namespace Modules\Settings\Http\Controllers\Web;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('get', [SettingsController::class, 'getSettings']);
Route::post('save', [SettingsController::class, 'saveSettings']);

Route::name('web_')->group(function () {
    Route::prefix('options')->name('options_')->group(function () {
    Route::get('country_code', [SettingsController::class, 'countryCodesOptions'])->name('country_code');
    });
});
