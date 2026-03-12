<?php

namespace Modules\Blog\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\Admin\BlogCategoryController;
use Modules\Blog\Http\Controllers\Admin\BlogController;

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

Route::middleware('auth:admin')->prefix('blog')->name('blog_')->group(function () {
    Route::get('/', [BlogController::class, 'list'])->name('list');
    Route::post('table', [BlogController::class, 'blogListData'])->name('table');
    Route::get('add-blog', [BlogController::class, 'add'])->name('add');
    Route::post('save-blog', [BlogController::class, 'create'])->name('save');
    Route::get('edit-blog', [BlogController::class, 'edit'])->name('edit');
    Route::post('update-blog', [BlogController::class, 'update'])->name('update');
    Route::delete('delete', [BlogController::class, 'delete'])->name('delete');
    Route::get('view-blog', [BlogController::class, 'viewBlog'])->name('view');
});


Route::middleware('auth:admin')->prefix('blog-category')->name('blog_category_')->group(function () {
    Route::get('/', [BlogCategoryController::class, 'listCategory'])->name('list');
    Route::get('add-blog-category', [BlogCategoryController::class, 'addCategory'])->name('add');
    Route::post('save', [BlogCategoryController::class, 'create'])->name('save');
    Route::post('table', [BlogCategoryController::class, 'categoryListData'])->name('table');
    Route::get('edit-category', [BlogCategoryController::class, 'editCategory'])->name('edit');
    Route::post('update-category', [BlogCategoryController::class, 'updateCategory'])->name('update');
    Route::delete('delete', [BlogCategoryController::class, 'deleteCategory'])->name('delete');
    Route::get('category-options', [BlogController::class, 'optionsCategory'])->name('options');

});