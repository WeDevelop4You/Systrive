<?php

    use App\Admin\Company\Controllers\CompaniesController;
    use App\Admin\Translation\Controllers\TranslationDataController;
    use App\Admin\User\Controllers\UserController;
    use App\Admin\User\Controllers\UserTableController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/user', [UserController::class, 'auth'])->name('auth.user');

        Route::prefix('companies')->group(function () {
            Route::get('/', [CompaniesController::class, 'navigation'])->name('user.company');

            Route::prefix('{company}')->middleware('company')->group(function () {
                Route::get('/', [CompaniesController::class, 'show'])->name('user.company.show');
            });
        });

        Route::prefix('admin')->group(function () {
            Route::prefix('users')->group(function ()  {
                Route::get('/', [UserTableController::class, 'index'])->name('admin.users');

                Route::prefix('{user}')->group(function () {
                    Route::delete('/', [UserTableController::class, 'destroy'])->name('admin.user');
                    Route::delete('force', [UserTableController::class, 'forceDestroy'])->name('admin.user.force')->withTrashed();
                });
            });

            Route::prefix('translations')->group(function () {

                Route::prefix('environments')->group(function () {
                    Route::get('/', [TranslationDataController::class, 'environments'])->name('admin.translations.environments');
                    Route::get('{environment}', [TranslationDataController::class, 'index'])->name('admin.translations.environment');
                });

                Route::prefix('{translationKey}')->group(function () {
                     Route::get('/', [TranslationDataController::class, 'edit'])->name('admin.translation');
                     Route::patch('/', [TranslationDataController::class, 'update'])->name('admin.translation');
                     Route::delete('/', [TranslationDataController::class, 'destroy'])->name('admin.translation');
                });
            });
        });
    });
