<?php

    use App\Admin\Authentication\Controllers\LoginController;
    use App\Admin\Authentication\Controllers\LogoutController;
    use App\Admin\Authentication\Controllers\PasswordRecoveryController;
    use App\Admin\Authentication\Controllers\RegistrationController;
    use App\Admin\Authentication\Controllers\ResetPasswordController;
    use App\Admin\Company\Controllers\CompanyInviteController;
    use Illuminate\Support\Facades\Route;

    Route::get('logout', [LogoutController::class, 'action'])->name('logout');

    Route::get('invite/company/{company}/{token}/{encryptEmail}', [CompanyInviteController::class, 'index'])->name('company.user.invite.link');

    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'index'])->name('web.login');

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
