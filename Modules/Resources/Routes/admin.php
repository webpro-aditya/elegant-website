<?php

namespace Modules\Resources\Http\Controllers\Admin;

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

Route::middleware('auth:admin')->name('free_resource_')->prefix('free-resource')->group(function () {
    Route::get('/', [FreeResourcesController::class, 'list'])->name('list');
    Route::post('/table', [FreeResourcesController::class, 'listTable'])->name('table');
    Route::get('add', [FreeResourcesController::class, 'add'])->name('add');
    Route::post('save', [FreeResourcesController::class, 'save'])->name('save');
    Route::get('edit', [FreeResourcesController::class, 'edit'])->name('edit');
    Route::post('update', [FreeResourcesController::class, 'update'])->name('update');
    Route::delete('delete', [FreeResourcesController::class, 'delete'])->name('delete');
    Route::get('view', [FreeResourcesController::class, 'view'])->name('view');

    Route::middleware('auth:admin')->prefix('contents')->name('contents_')->group(function () {
        Route::post('/table', [ResourceController::class, 'table'])->name('table');
        Route::post('/create', [ResourceController::class, 'save'])->name('create');
        Route::get('add', [ResourceController::class, 'add'])->name('add');
        Route::get('edit', [ResourceController::class, 'edit'])->name('edit');
        Route::post('update', [ResourceController::class, 'update'])->name('update');
        Route::delete('delete', [ResourceController::class, 'delete'])->name('delete');

    });

    Route::middleware('auth:admin')->prefix('quiz')->name('quiz_')->group(function () {
        Route::post('/table', [QuizController::class, 'table'])->name('table');
        Route::get('add', [QuizController::class, 'add'])->name('add');
        Route::post('save', [QuizController::class, 'save'])->name('save');
        Route::get('edit', [QuizController::class, 'edit'])->name('edit');
        Route::post('update', [QuizController::class, 'update'])->name('update');
        Route::delete('delete', [QuizController::class, 'delete'])->name('delete');
    });

});
