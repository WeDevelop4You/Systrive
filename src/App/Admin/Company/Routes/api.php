<?php

use App\Admin\Company\Controllers\CompanyCreateController;
use App\Admin\Company\Controllers\CompanyDestroyController;
use App\Admin\Company\Controllers\CompanyEditController;
use App\Admin\Company\Controllers\CompanyInviteController;
use App\Admin\Company\Controllers\CompanyNavigationController;
use App\Admin\Company\Controllers\CompanyOverviewController;
use App\Admin\Company\Controllers\CompanyResendInviteController;
use App\Admin\Company\Controllers\CompanyShowController;
use App\Admin\Company\Controllers\CompanyTableController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('search/{company:slug}', [CompanyShowController::class, 'index'])->name('company.search');

    Route::prefix('{company}')->group(function () {
        Route::get('show', [CompanyShowController::class, 'index'])->name('company.show');
        Route::get('navigation', [CompanyNavigationController::class, 'index'])->name('company.navigation');

        Route::prefix('create/{token}')->controller(CompanyCreateController::class)->group(function () {
            Route::get('/', 'index')->name('company.create');
            Route::put('/', 'action')->name('company.create');
        });
    });

    Route::prefix('admin')->middleware('role:super_admin')->group(function () {
        Route::dataTable(CompanyTableController::class, 'admin.company');
        Route::get('overview', [CompanyOverviewController::class, 'index'])->name('admin.company.overview');

        Route::prefix('invite')->group(function () {
            Route::post('{company}/resend', [CompanyResendInviteController::class, 'action'])->name('admin.company.invite.resend');

            Route::controller(CompanyInviteController::class)->group(function () {
                Route::get('/', 'index')->name('admin.company.invite');
                Route::post('/', 'action')->name('admin.company.invite');
            });
        });

        Route::prefix('{company}')->group(function () {
            Route::get('show', [CompanyShowController::class, 'index'])->name('admin.company.show');

            Route::prefix('edit')->controller(CompanyEditController::class)->group(function () {
                Route::get('/', 'index')->name('admin.company.edit');
                Route::patch('/', 'action')->name('admin.company.edit');
            });

            Route::prefix('delete')->controller(CompanyDestroyController::class)->group(function () {
                Route::get('/', 'index')->name('admin.company.destroy');
                Route::delete('/', 'action')->name('admin.company.destroy');
            });
        });
    });
});
