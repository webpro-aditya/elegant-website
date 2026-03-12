<?php

use Illuminate\Support\Facades\Route;
use Modules\Home\Http\Controllers\Web\HomeController;

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

Route::get('/', [HomeController::class, 'home'])->name('web_home');
Route::prefix('{locale}')->where(['locale' => 'ar|en|sp|fr'])->group(function () {

    Route::name('web_')->group(function () {
        Route::get('/', [HomeController::class, 'home'])->name('home');

        Route::middleware('web')->group(function () {
            Route::get('locale', [HomeController::class, 'locale'])->name('locale');
        });
    });
});
