<?php

    use App\Admin\Account\Controllers\AccountChangePasswordController;
    use App\Admin\Account\Controllers\AccountDisable2FAController;
    use App\Admin\Account\Controllers\AccountEnable2FAController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('settings')->group(function () {
            Route::patch('change/password', [AccountChangePasswordController::class, 'action'])->name('account.change.password');

            Route::prefix('2fa')->group(function () {
                Route::get('qrcode', [AccountEnable2FAController::class, 'index'])->name('account.2fa.qrcode');
                Route::post('validate', [AccountEnable2FAController::class, 'action'])->name('account.2fa.validate');
                Route::delete('disable', [AccountDisable2FAController::class, 'action'])->name('account.2fa.disable');
            });
        });
    });
