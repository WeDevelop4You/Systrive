<?php

namespace App\Admin\Company\User\Controllers;

use App\Admin\Company\User\Responses\CompanyUserOverviewResponse;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;

class CompanyUserOverviewController
{
    /**
     * @param Company $company
     *
     * @return JsonResponse
     */
    public function index(Company $company): JsonResponse
    {
        return CompanyUserOverviewResponse::create($company)->toJson();
    }
}
