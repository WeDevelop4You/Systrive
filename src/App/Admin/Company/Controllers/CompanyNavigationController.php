<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Resources\CompanyNavigationResource;

    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;

    class CompanyNavigationController
    {
        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function index(Company $company): JsonResponse
        {
            return Response::create()
                ->addData(new CompanyNavigationResource(
                    $company->systemUser()
                        ->with(['domains', 'dns', 'databases', 'mailDomains'])
                        ->first()
                ))
                ->toJson();
        }
    }
