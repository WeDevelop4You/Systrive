<?php

    use App\Admin\Authentication\Controllers\LoginController;
    use App\Admin\Authentication\Controllers\PasswordRecoveryController;
    use App\Admin\Authentication\Controllers\RegistrationController;
    use App\Admin\Authentication\Controllers\ResetPasswordController;
    use App\Admin\Authentication\Requests\PasswordRequest;
    use App\Admin\User\Account\Requests\ProfileRequest;
    use Illuminate\Http\Request;
    use Support\Helpers\Response\Response;

    Route::middleware(['guest', 'csrf'])->group(function () {
        Route::post('login', [LoginController::class, 'action'])->name('login');

        Route::post('password/recovery', [PasswordRecoveryController::class, 'action'])->name('password.recovery');

        Route::post('reset/password', [ResetPasswordController::class, 'action'])->name('reset.password');

        Route::prefix('registration')->group(function () {
            Route::post('/', [RegistrationController::class, 'action'])->name('registration');

            Route::prefix('validation')->group(function () {
                Route::post('password', function (PasswordRequest $request) {
                    return Response::create()->toJson();
                })->name('registration.validation.password');

                Route::post('profile', function (ProfileRequest $request) {
                    return Response::create()->toJson();
                })->name('registration.validation.profile');
            });
        });
    });

    Route::delete('delete/session', function (Request $request) {
        Session::forget($request->query('key'));

        return Response::create()->toJson();
    })->name('session.delete');
