<?php

namespace Modules\Seo\Http\Controllers\Admin;

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

Route::middleware('auth:admin')->name('seo_')->prefix('seo')->group(function () {
    Route::get('/', [SeoController::class, 'listSeo'])->name('list');
    Route::post('table', [SeoController::class, 'seoListData'])->name('table');
    Route::get('add-seo', [SeoController::class, 'add'])->name('add');
    Route::post('save-seo', [SeoController::class, 'save'])->name('save');
    Route::get('edit-seo', [SeoController::class, 'edit'])->name('edit');
    Route::post('update-seo', [SeoController::class, 'update'])->name('update');
    Route::delete('delete-seo', [SeoController::class, 'delete'])->name('delete');

    Route::get('model-options', [SeoController::class, 'modelOptions'])->name('model_options');

});