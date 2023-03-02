<?php

use App\Api\V1\Cms\Controllers\CmsGraphqlController;

Route::post('/', [CmsGraphQLController::class, 'index'])->name('cms');
