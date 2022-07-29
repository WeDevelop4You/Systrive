<?php

namespace App\Admin\Job\Controller;

use App\Admin\Job\Responses\JobShowResponse;
use Domain\Job\Models\JobOperation;
use Illuminate\Http\JsonResponse;

class JobShowController
{
    public function index(?JobOperation $schedule = null): JsonResponse
    {
        return JobShowResponse::create($schedule)->toJson();
    }
}
