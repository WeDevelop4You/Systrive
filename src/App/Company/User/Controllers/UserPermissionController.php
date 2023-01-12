<?php

    namespace App\Company\User\Controllers;

    use App\Admin\User\Resources\UserRoleResource;
    use App\Company\User\Resources\UserPermissionsResource;
    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Client\Response;

    class UserPermissionController
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
                $data = UserPermissionsResource::make($user);
            }

            return Response::create()
                ->addData($data)
                ->toJson();
        }
    }
