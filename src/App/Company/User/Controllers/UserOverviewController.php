<?php

namespace App\Company\User\Controllers;

use App\Company\User\Responses\UserOverviewResponse;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;

class UserOverviewController
{
    /**
     * @param Company $company
     *
     * @return JsonResponse
     */
    public function index(Company $company): JsonResponse
    {
        return UserOverviewResponse::create($company)->toJson();
    }
}
