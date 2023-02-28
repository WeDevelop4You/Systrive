<?php

use App\Api\V1\Cms\Controllers\CmsGraphqlController;

Route::post('test', [CmsGraphQLController::class, 'index'])
    ->middleware('auth:sanctum')
    ->name('cms');
