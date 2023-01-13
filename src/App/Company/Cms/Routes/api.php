<?php

use App\Company\Cms\Controllers\CmsSearchController;
use App\Company\Cms\Controllers\CmsTableConfirmController;
use App\Company\Cms\Controllers\CmsTableCreateController;
use App\Company\Cms\Controllers\CmsTableDestroyController;
use App\Company\Cms\Controllers\CmsTableEditController;
use App\Company\Cms\Controllers\CmsTableOverviewController;
use App\Company\Cms\Controllers\Column\CmsTableColumnCreateController;
use App\Company\Cms\Controllers\Column\CmsTableColumnDestroyController;
use App\Company\Cms\Controllers\Column\CmsTableColumnEditController;
use App\Company\Cms\Controllers\Column\CmsTableColumnListController;
use App\Company\Cms\Controllers\Column\CmsTableColumnTableController;
use App\Company\Cms\Controllers\Item\CmsTableItemCreateController;
use App\Company\Cms\Controllers\Item\CmsTableItemDestroyController;
use App\Company\Cms\Controllers\Item\CmsTableItemEditController;
use App\Company\Cms\Controllers\Item\CmsTableItemHistoryController;
use App\Company\Cms\Controllers\Item\CmsTableItemRestoreController;
use App\Company\Cms\Controllers\Item\CmsTableItemSaveController;
use App\Company\Cms\Controllers\Item\CmsTableItemTableController;
use App\Company\Cms\Controllers\Item\file\CmsTableItemFileUploader;

Route::scopeBindings()->middleware('permission.company:cms.view')->group(function () {
    Route::get('{cms:database}/search', [CmsSearchController::class, 'index'])->name('cms.search');

    Route::prefix('{cms}/tables')->middleware('cms')->group(function () {
        Route::get('{table:name}/search', [CmsTableOverviewController::class, 'index'])
            ->middleware('cms.table:name')
            ->name('cms.table.search');

        Route::prefix('columns')
            ->middleware('permission.company:cms.table.create|cms.table.edit')
            ->group(function () {
                Route::prefix('create')->controller(CmsTableColumnCreateController::class)->group(function () {
                    Route::get('/', 'index')->name('cms.table.column.create');
                    Route::post('/', 'action')->name('cms.table.column.create');
                });

                Route::prefix('{key}')->group(function () {
                    Route::get('edit', [CmsTableColumnEditController::class, 'index'])->name('cms.table.column.edit');
                    Route::get('delete', [CmsTableColumnDestroyController::class, 'index'])->name('cms.table.column.delete');
                });
            });

        Route::prefix('create')
            ->middleware('permission.company:cms.table.create')
            ->controller(CmsTableCreateController::class)
            ->group(function () {
                Route::get('/', 'index')->name('cms.table.create');
                Route::post('/', 'action')->name('cms.table.create');

                Route::prefix('columns')->group(function () {
                    Route::dataTable(CmsTableColumnTableController::class, 'cms.table.column.create');
                    Route::get('list', [CmsTableColumnListController::class, 'index'])->name('cms.table.column.create.list');
                });
            });

        Route::prefix('{table}')->middleware('cms.table')->group(function () {
            Route::post('columns/{column}/file', [CmsTableItemFileUploader::class, 'action'])
                ->middleware('permission.company:cms.table.create|cms.table.edit')
                ->name('cms.table.column.file');

            Route::middleware('permission.company:cms.table.edit')->group(function () {
                Route::get('confirm/save', [CmsTableConfirmController::class, 'index'])->name('cms.table.confirm');

                Route::prefix('edit')->controller(CmsTableEditController::class)->group(function () {
                    Route::get('/', 'index')->name('cms.table.edit');
                    Route::patch('/', 'action')->name('cms.table.edit');

                    Route::prefix('columns')->group(function () {
                        Route::dataTable(CmsTableColumnTableController::class, 'cms.table.column.edit');
                        Route::get('list', [CmsTableColumnListController::class, 'index'])->name('cms.table.column.edit.list');
                    });
                });
            });

            Route::prefix('delete')
                ->middleware('permission.company:cms.table.delete')
                ->controller(CmsTableDestroyController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('cms.table.destroy');
                    Route::delete('/', 'action')->name('cms.table.destroy');
                });

            Route::prefix('items')->group(function () {
                Route::dataTable(CmsTableItemTableController::class, 'cms.table.item');

                Route::prefix('create')
                    ->middleware('permission.company:cms.create')
                    ->controller(CmsTableItemCreateController::class)
                    ->group(function () {
                        Route::get('/', 'index')->name('cms.table.item.create');
                        Route::post('/', 'action')->name('cms.table.item.create');
                    });

                Route::prefix('{item}')->group(function () {
                    Route::prefix('edit')
                        ->middleware('permission.company:cms.edit')
                        ->controller(CmsTableItemEditController::class)
                        ->group(function () {
                            Route::get('/', 'index')->name('cms.table.item.edit');
                            Route::patch('/', 'action')->name('cms.table.item.edit');
                        });

                    Route::prefix('delete')
                        ->middleware('permission.company:cms.delete')
                        ->controller(CmsTableItemDestroyController::class)
                        ->group(function () {
                            Route::get('/', 'index')->name('cms.table.item.delete');
                            Route::delete('/', 'action')->name('cms.table.item.delete');
                        });
                });

                Route::prefix('save')->middleware('permission.company:cms.create|cms.edit')->group(function () {
                    Route::post('/', [CmsTableItemSaveController::class, 'action'])->name('cms.table.item.save');

                    Route::prefix('history')->middleware('permission.company:cms.restore')->group(function () {
                        Route::get('/', [CmsTableItemHistoryController::class, 'index'])->name('cms.table.item.history');

                        Route::prefix('{item}/restore')->controller(CmsTableItemRestoreController::class)->group(function () {
                            Route::get('/', 'index')->name('cms.table.item.history.restore');
                            Route::put('/', 'action')->name('cms.table.item.history.restore');
                        });
                    });
                });
            });
        });
    });
});
