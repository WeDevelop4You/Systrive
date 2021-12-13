<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\Resources\CompanyUserPermissionsResource;
    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\Response\Response;

    class CompanyUserPermissionController
    {
        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function index(Company $company): JsonResponse
        {
            return Response::create()
                ->addData(CompanyUserPermissionsResource::make(Auth::user()))
                ->toJson();
        }
    }
