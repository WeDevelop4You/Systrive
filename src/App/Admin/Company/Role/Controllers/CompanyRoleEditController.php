<?php

    namespace App\Admin\Company\Role\Controllers;

    use App\Admin\Company\Role\Requests\CompanyRoleRequest;
    use App\Admin\Company\Role\Responses\CompanyRoleEditResponse;
    use Domain\Company\Models\Company;
    use Domain\Role\Actions\UpdateRoleAction;
    use Domain\Role\DataTransferObjects\RoleData;
    use Domain\Role\Mappings\RoleTableMap;
    use Domain\Role\Models\Role;
    use Illuminate\Http\JsonResponse;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCode;

    class CompanyRoleEditController
    {
        /**
         * @param Company $company
         * @param Role    $role
         *
         * @return JsonResponse
         */
        public function index(Company $company, Role $role): JsonResponse
        {
            if (strtolower($role->name) !== RoleTableMap::ROLE_MAIN) {
                return CompanyRoleEditResponse::create($company, $role)->toJson();
            }

            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()
                        ->setText(trans('response.error.edit.admin.role'))
                )
                ->toJson();
        }

        /**
         * @param CompanyRoleRequest $request
         * @param Company            $company
         * @param Role               $role
         *
         * @return JsonResponse
         */
        public function action(CompanyRoleRequest $request, Company $company, Role $role): JsonResponse
        {
            if (strtolower($role->name) !== RoleTableMap::ROLE_MAIN) {
                $data = new RoleData(...$request->validated());

                (new UpdateRoleAction($role))($data);

                return Response::create()
                    ->addPopup(
                        SimpleNotificationComponent::create()
                        ->setText(trans('response.success.saved'))
                    )
                    ->toJson();
            }

            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()
                        ->setText(trans('response.error.update.admin.role')),
                    ResponseCode::HTTP_BAD_REQUEST
                )
                ->toJson();
        }
    }
