<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Responses\CompanyNavigationResponse;
    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;

    class CompanyNavigationController
    {
        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function index(Company $company): JsonResponse
        {
            return CompanyNavigationResponse::create($company)->toJson();
        }
    }
