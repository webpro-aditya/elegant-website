<?php

namespace Modules\Auth\Http\Controllers\Admin;

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

Route::middleware('guest:admin')->name('admin_')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::any('check_password', [LoginController::class, 'checkPassword'])->name('check_password');
    Route::any('check_email', [LoginController::class, 'checkEmail'])->name('check_email');
});

Route::middleware('auth:admin')->name('admin_')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
