<?php

use App\Account\Authentication\Controllers\LoginController;
use App\Account\Authentication\Controllers\RecoveryCodeController;
use App\Account\Authentication\Controllers\RecoveryController;
use App\Account\Authentication\Controllers\RegistrationController;
use App\Account\Authentication\Controllers\ResetPasswordController;
use App\Account\Authentication\Requests\PasswordRequest;
use App\Account\Authentication\Requests\UserProfileRequest;
use Support\Client\Response;

Route::middleware(['guest', 'csrf'])->group(function () {
    Route::prefix('login')->controller(LoginController::class)->group(function () {
        Route::get('/', 'index')->name('login');
        Route::post('/', 'action')->name('login');
        Route::post('recovery_code', 'action')->name('login.rc');
        Route::post('one_time_password', 'action')->name('login.otp');
    });

    Route::prefix('recovery')->controller(RecoveryController::class)->group(function () {
        Route::get('/', 'index')->name('recovery');
        Route::post('/', 'action')->name('recovery');
    });

    Route::prefix('reset/password')->controller(ResetPasswordController::class)->group(function () {
        Route::get('/', 'index')->name('reset.password');
        Route::post('/', 'action')->name('reset.password');
    });

    Route::get('recovery/code', [RecoveryCodeController::class, 'index'])->name('recovery.code');

    Route::prefix('registration')->group(function () {
        Route::controller(RegistrationController::class)->group(function () {
            Route::get('/', 'index')->name('registration');
            Route::post('/', 'action')->name('registration');
        });

        Route::prefix('validation')->group(function () {
            Route::post('password', function (PasswordRequest $request) {
                return Response::create()->toJson();
            })->name('registration.validation.password');

            Route::post('profile', function (UserProfileRequest $request) {
                return Response::create()->toJson();
            })->name('registration.validation.profile');
        });
    });
});
