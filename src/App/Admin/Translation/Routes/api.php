<?php

use App\Admin\Translation\Controllers\LocaleController;
use App\Admin\Translation\Controllers\TranslationDestroyController;
use App\Admin\Translation\Controllers\TranslationEditController;
use App\Admin\Translation\Controllers\TranslationOverviewController;
use App\Admin\Translation\Controllers\TranslationPublishController;
use App\Admin\Translation\Controllers\TranslationTableController;

Route::get('locales', [LocaleController::class, 'index'])->name('locales');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('admin')->middleware('role:super_admin')->group(function () {
        Route::dataTable(TranslationTableController::class, 'admin.translation', '{environment}');
        Route::post('publish', [TranslationPublishController::class, 'action'])->name('admin.translation.publish');
        Route::get('overview', [TranslationOverviewController::class, 'index'])->name('admin.translation.overview');

        Route::prefix('{translationKey}')->group(function () {
            Route::prefix('edit')->controller(TranslationEditController::class)->group(function () {
                Route::get('/', 'index')->name('admin.translation.edit');
                Route::patch('/', 'action')->name('admin.translation.edit');
            });

            Route::prefix('destroy')->controller(TranslationDestroyController::class)->group(function () {
                Route::get('/', 'index')->name('admin.translation.destroy');
                Route::delete('/', 'action')->name('admin.translation.destroy');
            });
        });
    });
});
