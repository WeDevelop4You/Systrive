<?php

    namespace App\Company\Role\Controllers;

    use App\Company\Role\Requests\RoleRequest;
    use App\Company\Role\Responses\RoleEditResponse;
    use Domain\Company\Models\Company;
    use Domain\Role\Actions\UpdateRoleAction;
    use Domain\Role\DataTransferObjects\RoleData;
    use Domain\Role\Mappings\RoleTableMap;
    use Domain\Role\Models\Role;
    use Illuminate\Http\JsonResponse;
    use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Client\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCode;

    class RoleEditController
    {
        /**
         * @param Company $company
         * @param Role    $role
         *
         * @return JsonResponse
         */
        public function index(Company $company, Role $role): JsonResponse
        {
            if ($role->name !== RoleTableMap::ROLE_MAIN) {
                return RoleEditResponse::create($company, $role)->toJson();
            }

            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()
                        ->setText(trans('response.error.edit.admin.role'))
                )
                ->toJson();
        }

        /**
         * @param RoleRequest $request
         * @param Company     $company
         * @param Role        $role
         *
         * @return JsonResponse
         */
        public function action(RoleRequest $request, Company $company, Role $role): JsonResponse
        {
            if ($role->name !== RoleTableMap::ROLE_MAIN) {
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
