<?php

namespace Modules\Auth\Http\Controllers\Api;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::prefix('user')->group(function () {

Route::post('token', [UserController::class, 'verifyLogin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('refresh_token', [UserController::class, 'refreshToken']);
    Route::post('register_device', [UserController::class, 'registerDevice']);
    Route::post('logout', [UserController::class, 'logout']);

});
// });
