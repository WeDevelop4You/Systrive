<?php

    use App\Admin\Translation\Controllers\LocaleController;
    use App\Admin\Translation\Controllers\TranslationDestroyController;
    use App\Admin\Translation\Controllers\TranslationEditController;
    use App\Admin\Translation\Controllers\TranslationPublishController;
    use App\Admin\Translation\Controllers\TranslationTableController;
    use Support\Helpers\Response\Response;

    Route::get('locales', function () {
        return Response::create()
            ->addData(config('translation.locales'))
            ->toJson();
    })->name('locales');

    Route::prefix('locale')->group(function () {
        Route::get('/', [LocaleController::class, 'index'])->name('locale');
        Route::put('{locale}', [LocaleController::class, 'action'])->middleware('csrf')->name('locale.change');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('admin')->middleware('role:super_admin')->group(function () {
            Route::post('publish', [TranslationPublishController::class, 'action'])->name('admin.translation.publish');
            Route::get('environments', [TranslationTableController::class, 'environments'])->name('admin.translations.environments');

            Route::prefix('table')->group(function () {
                Route::get('headers', [TranslationTableController::class, 'headers'])->name('admin.translation.table.headers');
                Route::get('items/{environment}', [TranslationTableController::class, 'items'])->name('admin.translation.table.items');
            });

            Route::prefix('{translationKey}')->group(function () {
                Route::get('/', [TranslationEditController::class, 'index'])->name('admin.translation');
                Route::patch('/', [TranslationEditController::class, 'action'])->name('admin.translation');
                Route::delete('/', [TranslationDestroyController::class, 'action'])->name('admin.translation');
            });
        });
    });
