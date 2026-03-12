<?php
 
namespace Modules\Subscriber\Http\Controllers\Web;

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
        Route::any('/subscribe', [SubscriberController::class, 'subscribe'])->name('subscribe');
    });
});
