<?php

use App\Admin\Account\Controllers\AccountChangePasswordController;
use App\Admin\Account\Controllers\AccountDisableOneTimePasswordController;
use App\Admin\Account\Controllers\AccountEnableOneTimePasswordController;
use App\Admin\Account\Controllers\AccountPreferenceController;
use App\Admin\Account\Controllers\AccountSettingsNavigationController;
use App\Admin\Account\Controllers\AccountSettingsOverviewController;
use App\Admin\Account\Controllers\AccountSettingsPageController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('preferences', [AccountPreferenceController::class, 'index'])->name('account.preferences');

    Route::prefix('settings')->group(function () {
        Route::get('navigation', [AccountSettingsNavigationController::class, 'index'])->name('account.settings.navigation');

        Route::prefix('overview')->group(function () {
            Route::get('/', [AccountSettingsOverviewController::class, 'index'])->name('account.settings.overview');
            Route::get('{page}', [AccountSettingsPageController::class, 'index'])->name('account.settings.overview.page');
        });

        Route::prefix('change')->group(function () {
            Route::patch('password', [AccountChangePasswordController::class, 'action'])->name('account.change.password');
            Route::patch('preferences', [AccountPreferenceController::class, 'action'])->name('account.change.preferences');
        });

        Route::prefix('otp')->group(function () {
            Route::get('qrcode', [AccountEnableOneTimePasswordController::class, 'index'])->name('account.settings.otp.qrcode');
            Route::post('validate', [AccountEnableOneTimePasswordController::class, 'action'])->name('account.settings.otp.validate');
            Route::delete('disable', [AccountDisableOneTimePasswordController::class, 'action'])->name('account.settings.otp.disable');
        });
    });
});
