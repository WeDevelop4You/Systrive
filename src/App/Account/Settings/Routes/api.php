<?php

use App\Account\Settings\Controllers\SettingsNavigationController;
use App\Account\Settings\Controllers\SettingsOverviewController;
use App\Account\Settings\Controllers\SettingsPageController;
use App\Account\Settings\Controllers\Type\SettingsDisableTwoFactorAuthenticationController;
use App\Account\Settings\Controllers\Type\SettingsEnableTwoFactorAuthenticationController;
use App\Account\Settings\Controllers\Type\SettingsPasswordController;
use App\Account\Settings\Controllers\Type\SettingsUserPersonalController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('navigation', [SettingsNavigationController::class, 'index'])->name('settings.navigation');

    Route::prefix('overview')->group(function () {
        Route::get('/', [SettingsOverviewController::class, 'index'])->name('settings.overview');
        Route::get('{page}', [SettingsPageController::class, 'index'])->name('settings.overview.page');
    });

    Route::prefix('type')->group(function () {
        Route::patch('password', [SettingsPasswordController::class, 'action'])->name('settings.password');
        Route::patch('personal', [SettingsUserPersonalController::class, 'action'])->name('settings.personal');

        Route::prefix('two_factor_authentication')->group(function () {
            Route::get('qrcode', [SettingsEnableTwoFactorAuthenticationController::class, 'index'])->name('settings.2fa.qrcode');
            Route::post('validate', [SettingsEnableTwoFactorAuthenticationController::class, 'action'])->name('settings.2fa.validate');
            Route::delete('disable', [SettingsDisableTwoFactorAuthenticationController::class, 'action'])->name('settings.2fa.disable');
        });
    });
});
