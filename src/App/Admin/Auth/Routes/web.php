<?php

    use App\Admin\Auth\Controllers\AuthenticationController;
    use App\Admin\Auth\Controllers\PasswordRecoveryController;
    use App\Admin\Auth\Controllers\ResetPasswordController;
    use App\Admin\Company\User\Controllers\CompanyUserInviteController;
    use Illuminate\Support\Facades\Route;

    Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticationController::class, 'index'])->name('login');
        Route::post('login', [AuthenticationController::class, 'login'])->name('login');

        Route::prefix('password/recovery')->group(function () {
            Route::get('/', [PasswordRecoveryController::class, 'index'])->name('password.recovery');
            Route::post('/', [PasswordRecoveryController::class, 'action'])->name('password.recovery');
        });

        Route::prefix('reset/password')->group(function () {
            Route::get('{token}/{encryptEmail}', [ResetPasswordController::class, 'index'])->name('reset.password.link');
            Route::post('/', [ResetPasswordController::class, 'action'])->name('reset.password');
        });
    });

    Route::get('invite/company/{company}/{token}/{encryptEmail}', [CompanyUserInviteController::class, 'index'])->name('company.user.invite.accepted');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('{any?}', function () {
            return view('admin::pages.dashboard');
        })->where('any', '^(?!api|login|password|reset|bot)[\/\w\.-]*')->name('dashboard');
    });

    Route::get('bot/detection', function () {
        return view('admin::pages.bot');
    })->name('bot.detection');
