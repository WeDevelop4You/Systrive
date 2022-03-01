<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\Resources\CompanyUserPermissionsResource;
    use App\Admin\User\Resources\UserRolesResource;
    use Domain\Company\Models\Company;
    use Domain\Role\Mappings\RoleTableMap;
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
            setCompanyId();
            $user = Auth::user();

            if ($user->hasRole(RoleTableMap::SUPER_ADMIN_ROLE)) {
                $data = UserRolesResource::make($user);
            } else {
                setCompanyId($company->id);
                $data = CompanyUserPermissionsResource::make($user);
            }

            return Response::create()
                ->addData($data)
                ->toJson();
        }
    }
