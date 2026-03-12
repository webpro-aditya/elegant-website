<?php

use Illuminate\Support\Facades\Route;
use Modules\Cms\Http\Controllers\Web\ContentController;

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
        Route::get('/contact-us', [ContentController::class, 'contactUs'])->name('contact_us');
        Route::get('/about', [ContentController::class, 'about'])->name('about');
        // Route::get('/hiring', [ContentController::class, 'hiring'])->name('hiring');
        Route::get('/corporate-training', [ContentController::class, 'corporateTraining'])->name('corporate_training');
        Route::get('/mentor', [ContentController::class, 'mentor'])->name('mentor');
        Route::get('/how-can-we-help', [ContentController::class, 'help'])->name('help');
        Route::get('/competency-assessment', [ContentController::class, 'competencyAssessment'])->name('competency_assessment');
        Route::get('/technical-documentation', [ContentController::class, 'technicalDocumentation'])->name('technical_documentation');
        Route::get('/privacy-policy', [ContentController::class, 'privacy'])->name('privacy');
        Route::get('/terms-and-conditions', [ContentController::class, 'terms'])->name('terms');
  
    });
});
