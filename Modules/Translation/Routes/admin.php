<?php

namespace Modules\Translation\Http\Controllers\Admin;

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

Route::middleware('auth:admin')->prefix('translation')->group(function () {
});

Route::middleware('auth:admin')->name('translation_')->prefix('translation')->group(function () {
    Route::get('/', [TranslationController::class, 'view'])->name('view');    
    Route::post('save_translation', [TranslationController::class, 'saveTranslation'])->name('save_translation');



});
