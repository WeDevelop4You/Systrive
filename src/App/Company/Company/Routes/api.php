<?php


use App\Company\Company\Controllers\CompanyCompleteController;

Route::prefix('complete/{token}')->controller(CompanyCompleteController::class)->group(function () {
    Route::get('/', 'index')->name('complete');
    Route::patch('/', 'action')->name('complete');
});
