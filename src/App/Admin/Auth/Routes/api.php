<?php

    use App\Admin\Auth\Controllers\AuthenticationController;
    use App\Admin\Auth\Controllers\PasswordRecoveryController;
    use App\Admin\Auth\Controllers\RegistrationController;
    use App\Admin\Auth\Controllers\ResetPasswordController;
    use App\Admin\Auth\Requests\PasswordRequest;
    use App\Admin\User\Controllers\UserController;
    use App\Admin\User\Requests\ProfileRequest;
    use Illuminate\Http\Request;
    use Support\Helpers\Response\Response;

    Route::middleware(['guest', 'csrf'])->group(function() {
        Route::post('login', [AuthenticationController::class, 'login'])->name('login');

        Route::post('password/recovery', [PasswordRecoveryController::class, 'action'])->name('password.recovery');

        Route::post('reset/password', [ResetPasswordController::class, 'action'])->name('reset.password');

        Route::prefix('registration')->group(function () {
            Route::post('/', [RegistrationController::class, 'action'])->name('registration');

            Route::prefix('validation')->group(function () {
                Route::post('password', function(PasswordRequest $request) {
                    return Response::create()->toJson();
                })->name('registration.validation.password');

                Route::post('profile', function(ProfileRequest $request) {
                    return Response::create()->toJson();
                })->name('registration.validation.profile');
            });
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/user', [UserController::class, 'auth'])->name('auth.user');

        Route::delete('delete/session', function(Request $request) {
            Session::forget($request->query('key'));

            return Response::create()->toJson();
        })->name('session.delete');
    });
