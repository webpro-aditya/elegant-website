<?php

use Illuminate\Support\Facades\Route;
use Modules\Career\Http\Controllers\CareerController;
use Modules\Career\Http\Controllers\Web\HiringController;

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
        Route::get('/hiring', [HiringController::class, 'hiring'])->name('hiring');
        Route::POST('/hiring-list', [HiringController::class, 'hiringList'])->name('hiring_list');
        Route::POST('/career-applicant', [HiringController::class, 'careerApplicant'])->name('save_career_applicant');
        Route::POST('/hire-applicant', [HiringController::class, 'applyHiring'])->name('apply_hiring');

    });
});
