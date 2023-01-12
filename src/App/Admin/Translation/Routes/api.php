<?php

use App\Admin\Translation\Controllers\TranslationDestroyController;
use App\Admin\Translation\Controllers\TranslationEditController;
use App\Admin\Translation\Controllers\TranslationOverviewController;
use App\Admin\Translation\Controllers\TranslationPublishController;
use App\Admin\Translation\Controllers\TranslationTableController;

Route::dataTable(TranslationTableController::class, 'translation', '{environment}');
Route::post('publish', [TranslationPublishController::class, 'action'])->name('translation.publish');
Route::get('overview', [TranslationOverviewController::class, 'index'])->name('translation.overview');

Route::prefix('{translationKey}')->group(function () {
    Route::prefix('edit')->controller(TranslationEditController::class)->group(function () {
        Route::get('/', 'index')->name('translation.edit');
        Route::patch('/', 'action')->name('translation.edit');
    });

    Route::prefix('destroy')->controller(TranslationDestroyController::class)->group(function () {
        Route::get('/', 'index')->name('translation.destroy');
        Route::delete('/', 'action')->name('translation.destroy');
    });
});
