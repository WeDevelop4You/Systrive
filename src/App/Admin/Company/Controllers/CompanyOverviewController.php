<?php

namespace App\Admin\Company\Controllers;

use App\Admin\Company\Responses\CompanyOverviewResponse;
use Illuminate\Http\JsonResponse;

class CompanyOverviewController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return CompanyOverviewResponse::create()->toJson();
    }
}
