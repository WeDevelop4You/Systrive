<?php

    use App\Admin\Account\Controllers\AccountRecoveryCodeController;

    Route::middleware('auth:sanctum')->prefix('download')->group(function () {
        Route::get('recovery/codes', [AccountRecoveryCodeController::class, 'action'])->name('account.download.recovery.codes');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('{any?}', function () {
            return view('admin::pages.dashboard');
        })->where('any', '^(?!api|authentication|bot|download)[\/\w\.-]*')->name('dashboard');
    });

    Route::get('bot/detection', function () {
        return view('admin::pages.bot');
    })->name('bot.detection');
