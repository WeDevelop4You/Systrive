<?php

namespace App\Admin\Startup\Controllers;

use App\Admin\Startup\Responses\MainNavigationResponse;
use Illuminate\Http\JsonResponse;

class MainNavigationController
{
    public function index(): JsonResponse
    {
        return MainNavigationResponse::create()->toJson();
    }
}
