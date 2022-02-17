<?php

    use App\Admin\User\Account\Controllers\UserAccountChangePasswordController;
    use App\Admin\User\Account\Controllers\UserAccountDisable2FAController;
    use App\Admin\User\Account\Controllers\UserAccountEnable2FAController;

    Route::middleware('auth:sanctum')->prefix('account')->group(function () {
        Route::prefix('settings')->group(function () {
            Route::patch('change/password', [UserAccountChangePasswordController::class, 'action'])->name('user.account.change.password');

            Route::prefix('2fa')->group(function () {
                Route::get('qrcode', [UserAccountEnable2FAController::class, 'index'])->name('user.account.2fa.qrcode');
                Route::post('validate', [UserAccountEnable2FAController::class, 'action'])->name('user.account.2fa.validate');
                Route::delete('disable', [UserAccountDisable2FAController::class, 'action'])->name('user.account.2fa.disable');
            });
        });
    });
