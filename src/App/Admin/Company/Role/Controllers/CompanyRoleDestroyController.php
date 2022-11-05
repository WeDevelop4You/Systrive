<?php

    namespace App\Admin\Company\Role\Controllers;

    use App\Admin\Company\Role\Responses\CompanyRoleDestroyResponse;
    use Domain\Company\Models\Company;
    use Domain\Role\Mappings\RoleTableMap;
    use Domain\Role\Models\Role;
    use Illuminate\Http\JsonResponse;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCode;

    class CompanyRoleDestroyController
    {
        public function index(Company $company, Role $role): JsonResponse
        {
            return CompanyRoleDestroyResponse::create($company, $role)->toJson();
        }

        /**
         * @param Company $company
         * @param Role    $role
         *
         * @return JsonResponse
         */
        public function action(Company $company, Role $role): JsonResponse
        {
            if (strtolower($role->name) !== RoleTableMap::ROLE_MAIN) {
                $role->delete();

                return Response::create()
                    ->addPopup(
                        SimpleNotificationComponent::create()
                        ->setText(trans('response.success.deleted'))
                    )
                    ->toJson();
            }

            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()
                        ->setText(trans('response.error.delete.admin.role')),
                    ResponseCode::HTTP_BAD_REQUEST
                )
                ->toJson();
        }
    }
