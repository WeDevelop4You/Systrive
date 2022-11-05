<?php

use App\Admin\Cms\Controllers\CmsCreateController;
use App\Admin\Cms\Controllers\CmsDestroyController;
use App\Admin\Cms\Controllers\CmsListController;
use App\Admin\Cms\Controllers\CmsRestoreController;
use App\Admin\Cms\Controllers\CmsSearchController;
use App\Admin\Cms\Controllers\CmsTableController;
use App\Admin\Cms\Controllers\Table\CmsTableConfirmController;
use App\Admin\Cms\Controllers\Table\CmsTableCreateController;
use App\Admin\Cms\Controllers\Table\CmsTableDestroyController;
use App\Admin\Cms\Controllers\Table\CmsTableEditController;
use App\Admin\Cms\Controllers\Table\CmsTableOverviewController;
use App\Admin\Cms\Controllers\Table\Column\CmsTableColumnCreateController;
use App\Admin\Cms\Controllers\Table\Column\CmsTableColumnDestroyController;
use App\Admin\Cms\Controllers\Table\Column\CmsTableColumnEditController;
use App\Admin\Cms\Controllers\Table\Column\CmsTableColumnListController;
use App\Admin\Cms\Controllers\Table\Column\CmsTableColumnTableController;
use App\Admin\Cms\Controllers\Table\Item\CmsTableItemCreateController;
use App\Admin\Cms\Controllers\Table\Item\CmsTableItemDestroyController;
use App\Admin\Cms\Controllers\Table\Item\CmsTableItemEditController;
use App\Admin\Cms\Controllers\Table\Item\CmsTableItemHistoryController;
use App\Admin\Cms\Controllers\Table\Item\CmsTableItemRestoreController;
use App\Admin\Cms\Controllers\Table\Item\CmsTableItemSaveController;
use App\Admin\Cms\Controllers\Table\Item\CmsTableItemTableController;

Route::middleware('auth:sanctum')->scopeBindings()->group(function () {
    Route::prefix('{company}/cms')->middleware('permission.company:cms.view')->group(function () {
        Route::get('{cms:database}/search', [CmsSearchController::class, 'index'])->name('company.cms.search');

        Route::prefix('{cms}/tables')->middleware('cms')->group(function () {
            Route::get('{table:name}/search', [CmsTableOverviewController::class, 'index'])
                ->middleware('cms.table:name')
                ->name('company.cms.table.search');

            Route::prefix('columns')
                ->middleware('permission.company:cms.table.create|cms.table.edit')
                ->group(function () {
                    Route::prefix('create')->controller(CmsTableColumnCreateController::class)->group(function () {
                        Route::get('/', 'index')->name('company.cms.table.column.create');
                        Route::post('/', 'action')->name('company.cms.table.column.create');
                    });

                    Route::prefix('{key}')->group(function () {
                        Route::get('edit', [CmsTableColumnEditController::class, 'index'])->name('company.cms.table.column.edit');
                        Route::get('delete', [CmsTableColumnDestroyController::class, 'index'])->name('company.cms.table.column.delete');
                    });
                });

            Route::prefix('create')
                ->middleware('permission.company:cms.table.create')
                ->controller(CmsTableCreateController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('company.cms.table.create');
                    Route::post('/', 'action')->name('company.cms.table.create');

                    Route::prefix('columns')->group(function () {
                        Route::dataTable(CmsTableColumnTableController::class, 'company.cms.table.column.create');
                        Route::get('list', [CmsTableColumnListController::class, 'index'])->name('company.cms.table.column.create.list');
                    });
                });

            Route::prefix('{table}')->middleware('cms.table')->group(function () {
                Route::middleware('permission.company:cms.table.edit')->group(function () {
                    Route::get('confirm/save', [CmsTableConfirmController::class, 'index'])->name('company.cms.table.confirm');

                    Route::prefix('edit')->controller(CmsTableEditController::class)->group(function () {
                        Route::get('/', 'index')->name('company.cms.table.edit');
                        Route::patch('/', 'action')->name('company.cms.table.edit');

                        Route::prefix('columns')->group(function () {
                            Route::dataTable(CmsTableColumnTableController::class, 'company.cms.table.column.edit');
                            Route::get('list', [CmsTableColumnListController::class, 'index'])->name('company.cms.table.column.edit.list');
                        });
                    });
                });

                Route::prefix('delete')
                    ->middleware('permission.company:cms.table.delete')
                    ->controller(CmsTableDestroyController::class)
                    ->group(function () {
                        Route::get('/', 'index')->name('company.cms.table.destroy');
                        Route::delete('/', 'action')->name('company.cms.table.destroy');
                    });

                Route::prefix('items')->group(function () {
                    Route::dataTable(CmsTableItemTableController::class, 'company.cms.table.item');

                    Route::prefix('create')
                        ->middleware('permission.company:cms.create')
                        ->controller(CmsTableItemCreateController::class)
                        ->group(function () {
                            Route::get('/', 'index')->name('company.cms.table.item.create');
                            Route::post('/', 'action')->name('company.cms.table.item.create');
                        });

                    Route::prefix('{item}')->group(function () {
                        Route::prefix('edit')
                            ->middleware('permission.company:cms.edit')
                            ->controller(CmsTableItemEditController::class)
                            ->group(function () {
                                Route::get('/', 'index')->name('company.cms.table.item.edit');
                                Route::patch('/', 'action')->name('company.cms.table.item.edit');
                            });

                        Route::prefix('delete')
                            ->middleware('permission.company:cms.delete')
                            ->controller(CmsTableItemDestroyController::class)
                            ->group(function () {
                                Route::get('/', 'index')->name('company.cms.table.item.delete');
                                Route::delete('/', 'action')->name('company.cms.table.item.delete');
                            });
                    });

                    Route::prefix('save')->middleware('permission.company:cms.create|cms.edit')->group(function () {
                        Route::post('/', [CmsTableItemSaveController::class, 'action'])->name('company.cms.table.item.save');

                        Route::prefix('history')->middleware('permission.company:cms.restore')->group(function () {
                            Route::get('/', [CmsTableItemHistoryController::class, 'index'])->name('company.cms.table.item.history');

                            Route::prefix('{item}/restore')->controller(CmsTableItemRestoreController::class)->group(function () {
                                Route::get('/', 'index')->name('company.cms.table.item.history.restore');
                                Route::put('/', 'action')->name('company.cms.table.item.history.restore');
                            });
                        });
                    });
                });
            });
        });
    });

    Route::prefix('admin/{company}/cms')->middleware('role:super_admin')->group(function () {
        Route::dataTable(CmsTableController::class, 'sa.company.cms');
        Route::get('list', [CmsListController::class, 'index'])->name('sa.company.cms.list');

        Route::prefix('create')->controller(CmsCreateController::class)->group(function () {
            Route::get('/', 'index')->name('sa.company.cms.create');
            Route::post('/', 'action')->name('sa.company.cms.create');
        });

        Route::prefix('{cms}')->group(function () {
            Route::put('restore', [CmsRestoreController::class, 'action'])->withTrashed()->name('sa.company.cms.restore');

            Route::prefix('delete')->controller(CmsDestroyController::class)->group(function () {
                Route::get('/', 'index')->name('sa.company.cms.destroy');
                Route::delete('/', 'action')->name('sa.company.cms.destroy');
            });
        });
    });
});
