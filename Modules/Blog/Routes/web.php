<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\Web\BlogController;

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
        Route::get('/blog', [BlogController::class, 'list'])->name('blog_list');
        Route::get('/blog-category/{category}', [BlogController::class, 'category'])->name('blog_category');
        Route::get('/blog-detail/{blog}', [BlogController::class, 'detail'])->name('blog_detail');
        Route::get('/blog-author-list', [BlogController::class, 'authorList'])->name('blog_author_list');
 
    });
});
