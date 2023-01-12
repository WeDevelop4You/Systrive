<?php

namespace App\Misc\Navigation\Controllers;

use App\Misc\Navigation\Responses\NavigationResponse;
use Illuminate\Http\JsonResponse;

class NavigationController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return NavigationResponse::create()->toJson();
    }
}
