<?php

namespace App\Admin\Company\Controllers;

use App\Admin\Company\Resources\CompanyResource;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Response\Response;

class CompanySearchController
{
    /**
     * @param Company $company
     *
     * @return JsonResponse
     */
    public function index(Company $company): JsonResponse
    {
        return Response::create()
            ->addData(CompanyResource::make($company))
            ->toJson();
    }
}
