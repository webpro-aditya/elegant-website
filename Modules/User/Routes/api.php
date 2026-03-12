<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth:sanctum')->prefix('user')->group(function () {

    Route::get('/', [UsersController::class, 'userInfo']);
    Route::post('table', [UsersController::class, 'table']);
    Route::get('get', [UsersController::class, 'get']);
    Route::post('save', [UsersController::class, 'save']);
    Route::post('update', [UsersController::class, 'update']);
    Route::post('delete', [UsersController::class, 'delete']);
    Route::post('changePassword', [UsersController::class, 'changePassword']);
    Route::get('get_auth_user', [UsersController::class, 'getUser']);

    /**
     * Role management
     */
    Route::prefix('role')->group(function () {
        Route::get('list', [RolesController::class, 'list']);
        Route::get('get', [RolesController::class, 'get']);
        Route::post('save', [RolesController::class, 'save']);
        Route::post('update', [RolesController::class, 'update']);
        Route::post('delete', [RolesController::class, 'delete']);
        Route::get('permissions', [RolesController::class, 'permissions']);

    });
});
