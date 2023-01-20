<?php

namespace App\Admin\Company\Controllers;

use App\Admin\Company\Responses\CompanyShowResponse;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyShowController
{
    /**
     * @param Request $request
     * @param Company $company
     *
     * @return JsonResponse
     */
    public function index(Request $request, Company $company): JsonResponse
    {
        return CompanyShowResponse::create($company)->toJson();
    }
}
