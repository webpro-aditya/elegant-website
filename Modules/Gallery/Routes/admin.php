<?php

namespace Modules\Gallery\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:admin')->prefix('gallery')->name('gallery_')->group(function () {
    Route::get('/', [GalleryController::class, 'listGallery'])->name('list');
    Route::post('table', [GalleryController::class, 'GalleryListData'])->name('table');
    Route::get('add-gallery', [GalleryController::class, 'addGallery'])->name('add');
    Route::post('save-gallery', [GalleryController::class, 'saveGallery'])->name('save');
    Route::delete('delete', [GalleryController::class, 'deleteGallery'])->name('delete');
    Route::get('edit-gallery', [GalleryController::class, 'editGallery'])->name('edit');
    Route::post('update-gallery', [GalleryController::class, 'updateGallery'])->name('update');

    Route::post('image_save', [GalleryController::class, 'imageSave'])->name('image_save');
    Route::get('fetch_image', [GalleryController::class, 'imageData'])->name('fetch_image');
    Route::get('image_delete', [GalleryController::class, 'imageDelete'])->name('image_delete');
    Route::post('data_update', [GalleryController::class, 'dataUpdate'])->name('data_update');
});
