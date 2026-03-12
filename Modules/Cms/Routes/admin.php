<?php

namespace Modules\Cms\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;
use Modules\Cms\Http\Controllers\Admin\CmsController;

/*
|--------------------------------------------------------------------------
| Lms Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:admin')->prefix('pages')->name('pages_')->group(function () {
    Route::get('/', [CmsController::class, 'listPages'])->name('list');
    Route::post('table', [CmsController::class, 'pageListData'])->name('table');

});

Route::middleware('auth:admin')->prefix('contents')->name('contents_')->group(function () {
    Route::get('view', [CmsController::class, 'view'])->name('view');
    Route::post('contents-table', [CmsController::class, 'contentsTable'])->name('contentsTable');
    Route::get('add-contents', [CmsController::class, 'add'])->name('add');
    Route::post('save-contents', [CmsController::class, 'save'])->name('save');
    Route::get('edit-contents', [CmsController::class, 'edit'])->name('edit');
    Route::post('update-contents', [CmsController::class, 'update'])->name('update');
    Route::delete('delete-content', [CmsController::class, 'delete'])->name('delete');
    Route::get('content-detail', [CmsController::class, 'viewContent'])->name('details');
    Route::get('content-overview', [CmsController::class, 'courseOverviewList'])->name('overview_list'); 
    Route::get('edit-section', [CmsController::class, 'editSection'])->name('edit_section');


    Route::post('image_save', [CmsController::class, 'imageSave'])->name('image_save');
    Route::get('fetch_image', [CmsController::class, 'imageData'])->name('fetch_image');
    Route::get('image_delete', [CmsController::class, 'imageDelete'])->name('image_delete');
    Route::post('data_update', [CmsController::class, 'dataUpdate'])->name('data_update');

});