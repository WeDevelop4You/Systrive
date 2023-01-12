<?php

namespace App\Company\Dashboard\Controllers;

use App\Company\Dashboard\Responses\SwitcherOverviewResponse;
use Illuminate\Http\JsonResponse;

class SwitcherOverviewController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return SwitcherOverviewResponse::create()->toJson();
    }
}
