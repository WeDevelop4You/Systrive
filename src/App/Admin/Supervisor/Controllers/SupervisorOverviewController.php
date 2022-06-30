<?php

namespace App\Admin\Supervisor\Controllers;

use App\Admin\Supervisor\Responses\SupervisorOverviewResponse;
use Illuminate\Http\JsonResponse;

class SupervisorOverviewController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return SupervisorOverviewResponse::create()->toJson();
    }
}
