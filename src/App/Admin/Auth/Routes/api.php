<?php

    use App\Admin\User\Controllers\UserController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/user', [UserController::class, 'auth'])->name('auth.user');
    });
