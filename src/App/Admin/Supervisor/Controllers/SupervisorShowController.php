<?php

namespace App\Admin\Supervisor\Controllers;

use App\Admin\Supervisor\Responses\SupervisorShowResponse;
use Illuminate\Http\JsonResponse;

class SupervisorShowController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return SupervisorShowResponse::create()->toJson();
    }
}
