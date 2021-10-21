<?php

    use App\Admin\Company\Controllers\CompanyTableController;
    use App\Admin\Translation\Controllers\TranslationPublishController;
    use App\Admin\User\Controllers\UserController;
    use App\Admin\User\Controllers\UserDestroyController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/user', [UserController::class, 'auth'])->name('auth.user');
    });
