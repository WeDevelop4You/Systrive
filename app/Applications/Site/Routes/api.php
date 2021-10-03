<?php

    use App\Site\Contact\Controllers\ContactController;
    use App\Site\Information\Controllers\InfoController;
    use App\Site\Team\Controllers\TeamController;

    Route::prefix('data')->group(function () {
        Route::get('team', [TeamController::class, 'team']);
        Route::get('teammates', [TeamController::class, 'index']);
        Route::get('about', [InfoController::class, 'about']);
        Route::get('websites', [InfoController::class, 'websites']);
        Route::post('contact', [ContactController::class, 'store']);
    });
