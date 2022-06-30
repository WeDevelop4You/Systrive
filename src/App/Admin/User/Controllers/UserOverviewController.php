<?php

namespace App\Admin\User\Controllers;

use App\Admin\User\Responses\UserOverviewResponse;
use Illuminate\Http\JsonResponse;

class UserOverviewController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return UserOverviewResponse::create()->toJson();
    }
}
