<?php


use App\Company\Company\Controllers\CompanyController;

Route::get('initialize', [CompanyController::class, 'index'])->name('initialize');
