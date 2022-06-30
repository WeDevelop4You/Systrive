<?php

use App\Admin\System\Template\Controllers\SystemTemplateListController;

Route::middleware('auth:sanctum')->prefix('templates')->group(function () {
    Route::get('{type}/list', [SystemTemplateListController::class, 'index'])->name('system.templates.list');
});
