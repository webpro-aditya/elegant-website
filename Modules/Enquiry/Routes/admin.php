<?php

namespace Modules\Enquiry\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:admin')->prefix('enquiry')->name('enquiry_')->group(function () {
    Route::get('/', [EnquiryController::class, 'list'])->name('list');
    Route::post('/table', [EnquiryController::class, 'table'])->name('table');
    Route::get('/detail', [EnquiryController::class, 'detail'])->name('detail');
    Route::delete('delete', [EnquiryController::class, 'delete'])->name('delete');
    Route::get('/export', [EnquiryController::class, 'exportEnquiries'])->name('export');
});

Route::middleware('auth:admin')->prefix('brochure')->name('brochure_')->group(function () {
    Route::get('/', [BrochureController::class, 'list'])->name('list');
    Route::post('/table', [BrochureController::class, 'table'])->name('table');
    Route::delete('delete', [BrochureController::class, 'delete'])->name('delete');
});

