<?php

namespace App\Admin\Startup\Controllers;

use App\Admin\Startup\Responses\SubNavigationResponse;
use Illuminate\Http\JsonResponse;

class SubNavigationController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return SubNavigationResponse::create()->toJson();
    }
}
