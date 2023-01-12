<?php

use App\Company\Dashboard\Controllers\SwitcherOverviewController;

Route::get('switcher', [SwitcherOverviewController::class, 'index'])->name('switcher.overview');
