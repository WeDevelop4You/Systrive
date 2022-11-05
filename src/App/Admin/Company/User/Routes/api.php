<?php

use App\Admin\Company\User\Controllers\CompanyUserEditController;
use App\Admin\Company\User\Controllers\CompanyUserInviteAcceptedController;
use App\Admin\Company\User\Controllers\CompanyUserInviteController;
use App\Admin\Company\User\Controllers\CompanyUserOverviewController;
use App\Admin\Company\User\Controllers\CompanyUserPermissionController;
use App\Admin\Company\User\Controllers\CompanyUserResendInviteController;
use App\Admin\Company\User\Controllers\CompanyUserRevokeController;
use App\Admin\Company\User\Controllers\CompanyUserTableController;

Route::prefix('{company}/users')
    ->middleware('auth:sanctum')
    ->middleware('permission.company:user.view')
    ->group(function () {
        Route::dataTable(CompanyUserTableController::class, 'company.user');
        Route::get('overview', [CompanyUserOverviewController::class, 'index'])->name('company.user.overview');
        Route::get('permissions', [CompanyUserPermissionController::class, 'index'])->name('company.user.permissions');

        Route::prefix('invite')->group(function () {
            Route::middleware('permission.company:user.invite')->group(function () {
                Route::post('{user}/resend', [CompanyUserResendInviteController::class, 'action'])->name('company.user.invite.resend')->withTrashed();

                Route::controller(CompanyUserInviteController::class)->group(function () {
                    Route::get('/', 'index')->name('company.user.invite');
                    Route::post('/', 'action')->name('company.user.invite');
                });
            });

            Route::prefix('{token}')->controller(CompanyUserInviteAcceptedController::class)->group(function () {
                Route::get('/', 'index')->name('company.user.invite.accepted');
                Route::post('/', 'action')->name('company.user.invite.accepted');
            });
        });

        Route::prefix('{user}')->scopeBindings()->group(function () {
            Route::prefix('edit')
                ->middleware('permission.company:user.edit')
                ->controller(CompanyUserEditController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('company.user.edit')->withTrashed();
                    Route::patch('/', 'action')->name('company.user.edit')->withTrashed();
                });

            Route::prefix('revoke')
                ->middleware('permission.company:user.revoke')
                ->controller(CompanyUserRevokeController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('company.user.revoke')->withTrashed();
                    Route::delete('/', 'action')->name('company.user.revoke')->withTrashed();
                });
        });
});
