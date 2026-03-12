<?php

use Illuminate\Support\Facades\Route;
use Modules\Enquiry\Http\Controllers\Admin\EnquiryController;
use Modules\Enquiry\Http\Controllers\Web\ContactUsController;

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

// Route::group([], function () {
//     Route::resource('enquiry', EnquiryController::class)->names('enquiry');
// });
Route::prefix('{locale}')->where(['locale' => 'ar|en'])->group(function () {
    Route::name('web_')->group(function () {
    Route::get('/contact-us', [ContactUsController::class, 'contact'])->name('contact_us');
   });
});


