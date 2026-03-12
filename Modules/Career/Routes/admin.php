<?php

namespace Modules\Career\Http\Controllers\Admin;

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

Route::middleware('auth:admin')->prefix('career-category')->name('career_category_')->group(function () {
    Route::get('/', [CareerCategoryController::class, 'list'])->name('list');
    Route::post('table', [CareerCategoryController::class, 'listData'])->name('table');
    Route::get('/add', [CareerCategoryController::class, 'add'])->name('add');
    Route::post('/save', [CareerCategoryController::class, 'create'])->name('save');
    Route::get('edit', [CareerCategoryController::class, 'edit'])->name('edit');
    Route::post('update', [CareerCategoryController::class, 'update'])->name('update');
    Route::delete('delete', [CareerCategoryController::class, 'delete'])->name('delete');
});

Route::get('category-options', [CareerController::class, 'optionsCategory'])->name('options_career_category');

Route::get('career-options', [CareerController::class, 'optionsCourses'])->name('options_active_career');

Route::middleware('auth:admin')->prefix('career')->name('career_')->group(function () {
    Route::get('/', [CareerController::class, 'list'])->name('list');
    Route::post('table', [CareerController::class, 'careerListData'])->name('table');
    Route::get('/add', [CareerController::class, 'add'])->name('add');
    Route::post('/save', [CareerController::class, 'save'])->name('save');
    Route::get('/edit', [CareerController::class, 'edit'])->name('edit');
    Route::post('/update', [CareerController::class, 'update'])->name('update');
    Route::delete('/delete', [CareerController::class, 'delete'])->name('delete');
    Route::get('/view', [CareerController::class, 'view'])->name('view');
});

Route::middleware('auth:admin')->prefix('career-applicant')->name('career_applicant_')->group(function () {
    Route::get('/', [CareerApplicantController::class, 'list'])->name('list');
    Route::post('table', [CareerApplicantController::class, 'careerListData'])->name('table');
    Route::get('/view', [CareerApplicantController::class, 'viewApplicant'])->name('view');
});
