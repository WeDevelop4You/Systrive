<?php

namespace App\Admin\Job\Controller;

use App\Admin\Job\Responses\JobOverviewResponse;
use Illuminate\Http\JsonResponse;

class JobOverviewController
{
    public function index(): JsonResponse
    {
        return JobOverviewResponse::create()->toJson();
    }
}
