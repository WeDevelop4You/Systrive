<?php

use App\Company\Dashboard\Controllers\DashboardController;
use Support\Helpers\ApplicationHelper;

Route::get('switcher', [DashboardController::class, 'index'])->name('view.switcher');
Route::get('{company:slug}/{any?}', [DashboardController::class, 'index'])
    ->where('company', '^(?!api|switcher|invites)[\w\-]*')
    ->where('any', '^[\/\w\.-]*')
    ->name('view.dashboard')
    ->missing(function () {
        return Redirect::to(ApplicationHelper::getSwitcherRoute());
    });
