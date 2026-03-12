<?php

namespace Modules\Author\Http\Controllers\Admin;

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

Route::middleware('auth:admin')->prefix('author')->name('author_')->group(function () {
    Route::get('/', [AuthorController::class, 'list'])->name('list');
    Route::post('table', [AuthorController::class, 'listTable'])->name('table');
    Route::get('add', [AuthorController::class, 'add'])->name('add');
    Route::post('save', [AuthorController::class, 'save'])->name('save');
    Route::get('edit', [AuthorController::class, 'edit'])->name('edit');
    Route::post('update', [AuthorController::class, 'update'])->name('update');
    Route::delete('delete', [AuthorController::class, 'delete'])->name('delete');
    Route::get('view-author', [AuthorController::class, 'viewAuthor'])->name('view');
    Route::get('author-options', [AuthorController::class, 'optionsAuthor'])->name('options');

});
