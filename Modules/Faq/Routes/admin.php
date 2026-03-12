<?php

namespace Modules\Faq\Http\Controllers\Admin;

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

Route::middleware('auth:admin')->prefix('faq')->name('faq_')->group(function () {
    Route::get('/', [FaqController::class, 'list'])->name('list');
    Route::post('/table', [FaqController::class, 'table'])->name('table');
    Route::get('add', [FaqController::class, 'add'])->name('add');
    Route::post('/save', [FaqController::class, 'save'])->name('save');
    Route::get('/edit', [FaqController::class, 'edit'])->name('edit');
    Route::post('/update', [FaqController::class, 'update'])->name('update');
    Route::delete('/delete', [FaqController::class, 'delete'])->name('delete');
});
