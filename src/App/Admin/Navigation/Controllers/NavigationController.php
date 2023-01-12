<?php

namespace App\Admin\Navigation\Controllers;

use App\Admin\Navigation\Responses\NavigationResponse;
use Illuminate\Http\JsonResponse;

class NavigationController
{
    public function index(): JsonResponse
    {
        return NavigationResponse::create()->toJson();
    }
}
