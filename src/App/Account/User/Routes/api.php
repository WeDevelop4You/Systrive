<?php

use App\Account\User\Controllers\UserController;
use App\Account\User\Controllers\UserLocaleController;
use App\Account\User\Controllers\UserPreferenceController;

Route::prefix('locale')->controller(UserLocaleController::class)->group(function () {
    Route::get('/', 'index')->name('locale');
    Route::put('{locale}', 'action')->middleware('csrf')->name('locale.change');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user');

    Route::prefix('preferences')->controller(UserPreferenceController::class)->group(function () {
        Route::get('/', 'index')->name('preferences');
        Route::patch('/', 'action')->name('preferences');
    });
});
