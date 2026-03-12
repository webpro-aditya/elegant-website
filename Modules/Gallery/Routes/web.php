<?php

namespace Modules\Gallery\Http\Controllers\Web;

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

Route::prefix('{locale}')->where(['locale' => 'ar|en'])->group(function () {
    Route::name('web_')->group(function () {
        Route::get('/gallery', [GalleryController::class, 'gallery'])->name('gallery');
    });
});
