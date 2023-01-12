<?php

namespace App\Company\Role\Controllers;

use App\Company\Role\Responses\RoleOverviewResponse;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;

class RoleOverviewController
{
    public function index(Company $company): JsonResponse
    {
        return RoleOverviewResponse::create($company)->toJson();
    }
}
