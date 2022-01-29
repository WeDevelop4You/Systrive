<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Resources\CompanyShowResource;

    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;

    class CompanyShowController
    {
        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function index(Company $company): JsonResponse
        {
            return Response::create()
                ->addData(CompanyShowResource::make($company))
                ->toJson();
        }
    }
