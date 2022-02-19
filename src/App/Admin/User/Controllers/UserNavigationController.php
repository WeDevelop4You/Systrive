<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\Resources\UserNavigationResource;
    use Domain\Company\Enums\CompanyUserStatusTypes;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\Response\Response;

    class UserNavigationController
    {
        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            $companies = Auth::user()
                ->whereCompanyStatus(CompanyUserStatusTypes::ACCEPTED)
                ->get();

            return Response::create()
                ->addData(UserNavigationResource::collection($companies))
                ->toJson();
        }
    }
