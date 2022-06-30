<?php

use App\Admin\User\Controllers\UserController;
use App\Admin\User\Controllers\UserDestroyController;
use App\Admin\User\Controllers\UserDestroyForceController;
use App\Admin\User\Controllers\UserListController;
use App\Admin\User\Controllers\UserLocaleController;
use App\Admin\User\Controllers\UserOverviewController;
use App\Admin\User\Controllers\UserPermissionsController;
use App\Admin\User\Controllers\UserTableController;

Route::prefix('locale')->group(function () {
    Route::get('/', [UserLocaleController::class, 'index'])->name('locale');
    Route::put('{locale}', [UserLocaleController::class, 'action'])->middleware('csrf')->name('locale.change');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('permissions', [UserPermissionsController::class, 'index'])->name('auth.user.permissions');

        Route::prefix('edit')->controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('auth.user');
            Route::patch('/', 'action')->name('auth.user');
        });
    });

    Route::prefix('admin')->middleware('role:super_admin')->group(function () {
        Route::dataTable(UserTableController::class, 'admin.user');
        Route::get('list', [UserListController::class, 'index'])->name('admin.user.list');
        Route::get('overview', [UserOverviewController::class, 'index'])->name('admin.user.overview');

        Route::prefix('{user}')->group(function () {
            Route::prefix('edit')->controller('')->group(function () {
                Route::get('/')->name('admin.user.edit');
            });

            Route::prefix('destroy')->group(function () {
                Route::delete('force', [UserDestroyForceController::class, 'action'])->name('admin.user.destroy.force')->withTrashed();

                Route::controller(UserDestroyController::class)->group(function () {
                    Route::get('/', 'index')->name('admin.user.destroy');
                    Route::delete('/', 'action')->name('admin.user.destroy');
                });
            });
        });
    });
});
