<?php

    use App\Admin\Translation\Controllers\TranslationDestroyController;
    use App\Admin\Translation\Controllers\TranslationEditController;
    use App\Admin\Translation\Controllers\TranslationPublishController;
    use App\Admin\Translation\Controllers\TranslationTableController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::post('publish', [TranslationPublishController::class, 'action'])->name('admin.translation.publish');

            Route::prefix('environments')->group(function () {
                Route::get('/', [TranslationTableController::class, 'environments'])->name('admin.translations.environments');
                Route::get('{environment}/table', [TranslationTableController::class, 'index'])->name('admin.translations.environment');
            });

            Route::prefix('{translationKey}')->group(function () {
                Route::get('/', [TranslationEditController::class, 'index'])->name('admin.translation');
                Route::patch('/', [TranslationEditController::class, 'action'])->name('admin.translation');
                Route::delete('/', [TranslationDestroyController::class, 'action'])->name('admin.translation');
            });
        });
    });
