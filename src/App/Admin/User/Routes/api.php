<?php

use App\Admin\User\Controllers\UserDestroyController;
use App\Admin\User\Controllers\UserForceDestroyController;
use App\Admin\User\Controllers\UserOverviewController;
use App\Admin\User\Controllers\UserTableController;

Route::dataTable(UserTableController::class, 'user');
Route::get('overview', [UserOverviewController::class, 'index'])->name('user.overview');

Route::prefix('{user}')->group(function () {
    Route::prefix('edit')->controller('')->group(function () {
        Route::get('/')->name('user.edit')->withTrashed();
    });

    Route::prefix('destroy')->group(function () {
        Route::delete('force', [UserForceDestroyController::class, 'action'])->name('user.destroy.force')->withTrashed();

        Route::controller(UserDestroyController::class)->group(function () {
            Route::get('/', 'index')->name('user.destroy')->withTrashed();
            Route::delete('/', 'action')->name('user.destroy');
        });
    });
});
