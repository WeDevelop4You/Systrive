<?php

namespace App\Admin\Company\Role\Controllers;

use App\Admin\Company\Role\Responses\CompanyRoleOverviewResponse;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;

class CompanyRoleOverviewController
{
    public function index(Company $company): JsonResponse
    {
        return CompanyRoleOverviewResponse::create($company)->toJson();
    }
}
