<?php

use App\Company\Role\Controllers\RoleCreateController;
use App\Company\Role\Controllers\RoleDestroyController;
use App\Company\Role\Controllers\RoleEditController;
use App\Company\Role\Controllers\RoleOverviewController;
use App\Company\Role\Controllers\RoleTableController;

Route::middleware('permission.company:role.view')->group(function () {
    Route::dataTable(RoleTableController::class, 'role');
    Route::get('overview', [RoleOverviewController::class, 'index'])->name('role.overview');

    Route::prefix('create')
        ->middleware('permission.company:role.create')
        ->controller(RoleCreateController::class)
        ->group(function () {
            Route::get('/', 'index')->name('role.create');
            Route::post('/', 'action')->name('role.create');
        });

    Route::prefix('{role}')->scopeBindings()->group(function () {
        Route::prefix('edit')
            ->middleware('permission.company:role.edit')
            ->controller(RoleEditController::class)
            ->group(function () {
                Route::get('/', 'index')->name('role.edit');
                Route::patch('/', 'action')->name('role.edit');
            });

        Route::prefix('destroy')
            ->middleware('permission.company:role.delete')
            ->controller(RoleDestroyController::class)
            ->group(function () {
                Route::get('/', 'index')->name('role.destroy');
                Route::delete('/', 'action')->name('role.destroy');
            });
    });
});
