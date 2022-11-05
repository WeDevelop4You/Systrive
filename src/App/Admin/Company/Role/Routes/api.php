<?php

use App\Admin\Company\Role\Controllers\CompanyRoleCreateController;
use App\Admin\Company\Role\Controllers\CompanyRoleDestroyController;
use App\Admin\Company\Role\Controllers\CompanyRoleEditController;
use App\Admin\Company\Role\Controllers\CompanyRoleListController;
use App\Admin\Company\Role\Controllers\CompanyRoleOverviewController;
use App\Admin\Company\Role\Controllers\CompanyRoleTableController;

Route::prefix('{company}/roles')
    ->middleware('auth:sanctum')
    ->middleware('permission.company:role.view')
    ->group(function () {
        Route::dataTable(CompanyRoleTableController::class, 'company.role');
        Route::get('list', [CompanyRoleListController::class, 'index'])->name('company.role.list');
        Route::get('overview', [CompanyRoleOverviewController::class, 'index'])->name('company.role.overview');

        Route::prefix('create')
            ->middleware('permission.company:role.create')
            ->controller(CompanyRoleCreateController::class)
            ->group(function () {
                Route::get('/', 'index')->name('company.role.create');
                Route::post('/', 'action')->name('company.role.create');
            });

        Route::prefix('{role}')->scopeBindings()->group(function () {
            Route::prefix('edit')
                ->middleware('permission.company:role.edit')
                ->controller(CompanyRoleEditController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('company.role.edit');
                    Route::patch('/', 'action')->name('company.role.edit');
                });

            Route::prefix('destroy')
                ->middleware('permission.company:role.delete')
                ->controller(CompanyRoleDestroyController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('company.role.destroy');
                    Route::delete('/', 'action')->name('company.role.destroy');
                });
        });
});
