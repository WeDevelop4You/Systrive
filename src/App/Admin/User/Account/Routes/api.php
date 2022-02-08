<?php

    use App\Admin\User\Account\Controllers\UserAccountChangePasswordController;

    Route::middleware('auth:sanctum')->prefix('account')->group(function () {
        Route::prefix('settings')->group(function () {
            Route::patch('change/password', [UserAccountChangePasswordController::class, 'action'])->name('user.account.change.password');
        });
    });
