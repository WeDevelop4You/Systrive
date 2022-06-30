<?php

namespace App\Admin\Supervisor\Controllers;

use App\Admin\Supervisor\Responses\SupervisorProcessEditResponse;
use Illuminate\Http\JsonResponse;

class SupervisorProcessEditController
{
    public function index(): JsonResponse
    {
        return SupervisorProcessEditResponse::create()->toJson();
    }

    public function action(): JsonResponse
    {
    }
}
