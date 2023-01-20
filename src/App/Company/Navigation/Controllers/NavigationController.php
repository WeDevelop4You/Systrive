<?php

namespace App\Company\Navigation\Controllers;

use App\Company\Navigation\Responses\NavigationResponse;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;

class NavigationController
{
    /**
     * @param Company $company
     *
     * @return JsonResponse
     */
    public function index(Company $company): JsonResponse
    {
        return NavigationResponse::create($company)->toJson();
    }
}
