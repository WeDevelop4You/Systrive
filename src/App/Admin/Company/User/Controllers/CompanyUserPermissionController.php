<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\Resources\CompanyUserPermissionsResource;
    use App\Admin\User\Resources\UserRoleResource;
    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Response\Response;

    class CompanyUserPermissionController
    {
        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function index(Company $company): JsonResponse
        {
            setCompanyId();
            $user = Auth::user();

            if ($user->isSuperAdmin()) {
                $data = UserRoleResource::make($user);
            } else {
                setCompanyId($company->id);
                $data = CompanyUserPermissionsResource::make($user);
            }

            return Response::create()
                ->addData($data)
                ->toJson();
        }
    }
