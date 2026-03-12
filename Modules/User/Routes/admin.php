<?php

namespace Modules\User\Http\Controllers\Admin;

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

Route::middleware('auth:admin')->prefix('user')->name('user_')->group(function () {
    /**
     * User management
     */
    Route::get('/', [UsersController::class, 'listUsers'])->name('list');
    Route::post('table', [UsersController::class, 'userListData'])->name('table');
    Route::get('add', [UsersController::class, 'addUser'])->name('add');
    Route::post('create', [UsersController::class, 'createUser'])->name('create');
    Route::get('view', [UsersController::class, 'editUser'])->name('edit');
    Route::post('update', [UsersController::class, 'updateUser'])->name('update');
    Route::get('change_password', [UsersController::class, 'changeUserPassword'])->name('change_password');
    Route::post('update_password', [UsersController::class, 'updateUserPassword'])->name('update_password');
    Route::delete('delete', [UsersController::class, 'deleteUser'])->name('delete');

    /**
     * Role management
     */
    Route::middleware('auth:admin')->prefix('role')->name('role_')->group(function () {
        Route::get('/', [RolesController::class, 'listRoles'])->name('list');
        Route::get('add', [RolesController::class, 'addRole'])->name('add');
        Route::post('create', [RolesController::class, 'createRole'])->name('create');
        Route::get('view', [RolesController::class, 'viewRole'])->name('view');
        Route::post('users_table', [RolesController::class, 'rolesUsersListData'])->name('users_table');
        Route::get('edit', [RolesController::class, 'editRole'])->name('edit');
        Route::post('update', [RolesController::class, 'updateRole'])->name('update');
        Route::post('status_change', [RolesController::class, 'statusChange'])->name('status_change');
        Route::get('delete', [RolesController::class, 'deleteRole'])->name('delete');
        Route::post('check', [RolesController::class, 'checkRole'])->name('check');
    });
});

/**
 * Options
 */
Route::prefix('options')->name('options_')->group(function () {
    Route::get('roles', [RolesController::class, 'roleOptions'])->name('roles');
    Route::get('users', [UsersController::class, 'userOptions'])->name('users');
});
