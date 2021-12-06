<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Resources\CompanyNavigationResource;

    use Domain\User\Models\UserInvite;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\Response\Response;

    class CompanyNavigationController
    {
        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            $companies = Auth::user()
                ->companies()
                ->wherePivot('status',UserInvite::INVITE_USER_ACCEPTED)
                ->get();

            $response = new Response();
            $response->addData(CompanyNavigationResource::collection($companies));

            return $response->toJson();
        }
    }
