<?php

use App\Company\Invite\Controllers\InviteUserAcceptedController;
use App\Company\User\Controllers\UserEditController;
use App\Company\User\Controllers\UserInviteController;
use App\Company\User\Controllers\UserOverviewController;
use App\Company\User\Controllers\UserPermissionController;
use App\Company\User\Controllers\UserResendInviteController;
use App\Company\User\Controllers\UserRevokeController;
use App\Company\User\Controllers\UserTableController;

Route::middleware('permission.company:user.view')
    ->group(function () {
        Route::dataTable(UserTableController::class, 'user');
        Route::get('overview', [UserOverviewController::class, 'index'])->name('user.overview');
        Route::get('permissions', [UserPermissionController::class, 'index'])->name('user.permissions');

        Route::prefix('invite')->group(function () {
            Route::middleware('permission.company:user.invite')->group(function () {
                Route::post('{user}/resend', [UserResendInviteController::class, 'action'])->name('user.invite.resend')->withTrashed();

                Route::controller(UserInviteController::class)->group(function () {
                    Route::get('/', 'index')->name('user.invite');
                    Route::post('/', 'action')->name('user.invite');
                });
            });

            Route::prefix('{token}')->controller(InviteUserAcceptedController::class)->group(function () {
                Route::get('/', 'index')->name('user.invite.accepted');
                Route::post('/', 'action')->name('user.invite.accepted');
            });
        });

        Route::prefix('{user}')->scopeBindings()->group(function () {
            Route::prefix('edit')
                ->middleware('permission.company:user.edit')
                ->controller(UserEditController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('user.edit')->withTrashed();
                    Route::patch('/', 'action')->name('user.edit')->withTrashed();
                });

            Route::prefix('revoke')
                ->middleware('permission.company:user.revoke')
                ->controller(UserRevokeController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('user.revoke')->withTrashed();
                    Route::delete('/', 'action')->name('user.revoke')->withTrashed();
                });
        });
    });
