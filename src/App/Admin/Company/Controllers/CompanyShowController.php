<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Resources\CompanyNavigationResource;
    use App\Admin\Company\Resources\CompanyResource;
    use App\Controller;
    use Domain\Companies\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\Response\Response;

    class CompanyShowController extends Controller
    {
        /**
         * @param Company $company
         * @return JsonResponse
         */
        public function index(Company $company): JsonResponse
        {
            $response = new Response();
            $response->addData($company, CompanyResource::class);

            return $response->toJson();
        }

        /**
         * @return JsonResponse
         */
        public function navigation(): JsonResponse
        {
            $companies = Auth::user()->companies;

            $response = new Response();
            $response->addData($companies, CompanyNavigationResource::class, true);

            return $response->toJson();
        }
    }
