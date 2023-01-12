<?php

use App\Account\Settings\Controllers\Type\SettingsRecoveryCodeController;
use Support\Helpers\ApplicationHelper;

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('auth:sanctum')->prefix('download')->group(function () {
        Route::get('recovery/codes', [SettingsRecoveryCodeController::class, 'action'])->name('settings.download.recovery.codes');
    });

    Route::get('/', function () {
        return redirect(ApplicationHelper::getSettingsRoute());
    });

    Route::get('{any}', function () {
        return view('account::pages.dashboard');
    })->where('any', '^(?!download)[\/\w\.-]*')->name('view.settings');
});
