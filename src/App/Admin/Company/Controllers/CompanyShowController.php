<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\ListDetails\CompanyListDetail;
    use App\Admin\Company\Resources\CompanyShowResource;

    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
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
            if (Auth::user()->hasRole('super_admin')) {
                $company->listDetails = CompanyListDetail::create($company);
            }

            return Response::create()
                ->addData(CompanyShowResource::make($company))
                ->toJson();
        }
    }
