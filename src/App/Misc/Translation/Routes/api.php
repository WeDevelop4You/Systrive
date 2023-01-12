<?php

use App\Misc\Translation\Controllers\TranslationLocalesController;
use Illuminate\Support\Facades\Route;

Route::get('locales', [TranslationLocalesController::class, 'index'])->name('locales');
