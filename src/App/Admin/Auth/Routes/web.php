<?php

    use App\Admin\Auth\Controllers\AuthenticationController;
    use App\Admin\Auth\Controllers\PasswordRecoveryController;
    use App\Admin\Auth\Controllers\RegistrationController;
    use App\Admin\Auth\Controllers\ResetPasswordController;
    use App\Admin\Company\Controllers\CompanyInviteController;
    use App\Admin\Company\User\Controllers\CompanyUserInviteController;
    use Illuminate\Support\Facades\Route;

    Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

    Route::get('invite/company/{company}/{token}/{encryptEmail}', [CompanyInviteController::class, 'index'])->name('company.user.invite.link');

    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticationController::class, 'index'])->name('web.login');

        Route::get('password/recovery', [PasswordRecoveryController::class, 'index'])->name('web.password.recovery');

        Route::get('reset/password/{token}/{encryptEmail}', [ResetPasswordController::class, 'index'])->name('reset.password.link');

        Route::get('registration', [RegistrationController::class, 'index'])->name('web.registration');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('{any?}', function () {
            return view('admin::pages.dashboard');
        })->where('any', '^(?!api|login|password|reset|bot)[\/\w\.-]*')->name('dashboard');
    });

    Route::get('bot/detection', function () {
        return view('admin::pages.bot');
    })->name('bot.detection');
