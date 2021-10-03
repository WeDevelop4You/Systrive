<?php

    use App\Admin\Auth\Controllers\AuthenticationController;
    use App\Admin\Auth\Controllers\PasswordRecoveryController;
    use App\Admin\Auth\Controllers\ResetPasswordController;
    use Illuminate\Support\Facades\Route;

    Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticationController::class, 'index'])->name('login');
        Route::post('login', [AuthenticationController::class, 'login'])->name('login');
        Route::get('password/recovery', [PasswordRecoveryController::class, 'index'])->name('password.recovery');
        Route::get('reset/password', [ResetPasswordController::class, 'index'])->name('reset.password');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('{any?}', function (){
            return view('admin::pages.dashboard');
        })->where('any', '^(?!api|storage|login|password|reset|bot)[\/\w\.-]*')->name('dashboard');
    });

    Route::get('bot/detection', function () {
        return view('pages.bot');
    })->name('bot.detection');
