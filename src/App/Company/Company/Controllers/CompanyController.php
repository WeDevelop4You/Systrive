<?php

namespace App\Company\Company\Controllers;

use App\Company\Dashboard\Resources\CompanyResource;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Response;

class CompanyController
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
            ->addAction(VuexAction::create()->dispatch(
                'navigation/main',
                route('company.navigation', $company->id)
            ))
            ->toJson();
    }
}
