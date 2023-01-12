<?php

use App\Admin\Cms\Controllers\CmsCreateController;
use App\Admin\Cms\Controllers\CmsDestroyController;
use App\Admin\Cms\Controllers\CmsRestoreController;
use App\Admin\Cms\Controllers\CmsTableController;

Route::prefix('{company}/cms')->group(function () {
    Route::dataTable(CmsTableController::class, 'company.cms');

    Route::prefix('create')->controller(CmsCreateController::class)->group(function () {
        Route::get('/', 'index')->name('company.cms.create');
        Route::post('/', 'action')->name('company.cms.create');
    });

    Route::prefix('{cms}')->group(function () {
        Route::put('restore', [CmsRestoreController::class, 'action'])->withTrashed()->name('company.cms.restore');

        Route::prefix('delete')->controller(CmsDestroyController::class)->group(function () {
            Route::get('/', 'index')->name('company.cms.destroy');
            Route::delete('/', 'action')->name('company.cms.destroy');
        });
    });
});
