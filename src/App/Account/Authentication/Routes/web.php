<?php

use App\Account\Authentication\Controllers\LogoutController;
use App\Account\Authentication\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

Route::get('logout', [LogoutController::class, 'action'])->name('logout')->domain('');

Route::middleware('guest')->group(function () {
    Route::get('registration', [ViewController::class, 'index'])->name('view.registration');
    Route::get('reset/{token}/{encryptEmail}', [ViewController::class, 'index'])->name('view.reset.password');

    Route::get('{any?}', [ViewController::class, 'index'])->where('any', '^(?!api|registration|reset|logout)[\/\w\.-]*')->name('view.auth');
});
