<?php

use App\Admin\Company\Controllers\CompanyDestroyController;
use App\Admin\Company\Controllers\CompanyEditController;
use App\Admin\Company\Controllers\CompanyForceDestroyController;
use App\Admin\Company\Controllers\CompanyInviteController;
use App\Admin\Company\Controllers\CompanyOverviewController;
use App\Admin\Company\Controllers\CompanyResendInviteController;
use App\Admin\Company\Controllers\CompanyRestoreController;
use App\Admin\Company\Controllers\CompanyShowController;
use App\Admin\Company\Controllers\CompanyTableController;

Route::dataTable(CompanyTableController::class, 'company');
Route::get('overview', [CompanyOverviewController::class, 'index'])->name('company.overview');

Route::prefix('invite')->group(function () {
    Route::post('{company}/resend', [CompanyResendInviteController::class, 'action'])->name('company.invite.resend');

    Route::controller(CompanyInviteController::class)->group(function () {
        Route::get('/', 'index')->name('company.invite');
        Route::post('/', 'action')->name('company.invite');
    });
});

Route::prefix('{company}')->group(function () {
    Route::get('show', [CompanyShowController::class, 'index'])->name('company.show');
    Route::put('restore', [CompanyRestoreController::class, 'action'])->name('company.restore');

    Route::prefix('edit')->controller(CompanyEditController::class)->group(function () {
        Route::get('/', 'index')->name('company.edit');
        Route::patch('/', 'action')->name('company.edit');
    });

    Route::prefix('delete')->group(function () {
        Route::controller(CompanyDestroyController::class)->group(function () {
            Route::get('/', 'index')->name('company.destroy');
            Route::delete('/', 'action')->name('company.destroy');
        });

        Route::delete('force', [CompanyForceDestroyController::class, 'action'])->name('company.destroy.force');
    });
});
