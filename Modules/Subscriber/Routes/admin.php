<?php

namespace Modules\Subscriber\Http\Controllers\Admin;

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

Route::middleware('auth:admin')->prefix('subscriber')->name('subscriber_')->group(function () {
    Route::get('/', [SubscriberController::class, 'listSubscriber'])->name('list');
    Route::post('table', [SubscriberController::class, 'SubscriberListData'])->name('table');
    Route::delete('delete', [SubscriberController::class, 'deleteSubscriber'])->name('delete');
    // Route::get('venue-options', [VenueController::class, 'venueOptions'])->name('options_venue');
    Route::get('email-options', [SubscriberController::class, 'subscriberEmailOptions'])->name('options_email');

});
