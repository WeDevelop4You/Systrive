<?php

use App\Admin\Account\Controllers\AccountRecoveryCodeController;

Route::middleware('auth:sanctum')->prefix('download')->group(function () {
    Route::get('recovery/codes', [AccountRecoveryCodeController::class, 'action'])->name('account.download.recovery.codes');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('{any?}', function () {
        return view('admin::pages.dashboard');
    })->where('any', '^(?!api|authentication|bot|download|git|mailable|invite)[\/\w\.-]*')->name('dashboard');
});

Route::get('bot/detection', function () {
    return view('admin::pages.bot');
})->name('bot.detection');

Route::get('mailable', function () {
    return \Domain\Job\Models\JobOperation::whereScheduleWithChildUuid('776bd9ea-dbf7-472d-92e7-28a582352984')->toSql();
//        return (new \Domain\User\Notifications\UserPasswordChangeNotification())->toMail(null);
});
