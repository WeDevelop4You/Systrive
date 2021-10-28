<?php

    Route::get('/{any?}', function () {
        return view('site::welcome');
    })->where('any', '^(?!api\/)[\/\w\.-]*');
