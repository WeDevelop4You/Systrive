<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Resources\CompanyNavigationResource;
    use App\Admin\Company\Resources\CompanyResource;
    use App\Controller;
    use Domain\Companies\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\Response\Response;

    class CompanyNavigationController extends Controller
    {
        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            $companies = Auth::user()->companies;

            $response = new Response();
            $response->addData($companies, CompanyNavigationResource::class, true);

            return $response->toJson();
        }
    }
