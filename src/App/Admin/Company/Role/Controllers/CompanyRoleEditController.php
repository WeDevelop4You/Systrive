<?php

    namespace App\Admin\Company\Role\Controllers;

    use App\Admin\Company\Role\Requests\CompanyRoleRequest;
    use App\Admin\Company\Role\Resources\CompanyRoleResource;
    use Domain\Company\Models\Company;
    use Domain\Role\Actions\UpdateRoleAction;
    use Domain\Role\DataTransferObjects\RoleData;
    use Domain\Role\Mappings\RoleTableMap;
    use Domain\Role\Models\Role;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

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
            $response = new Response();

            if ($role->name !== RoleTableMap::MAIN_ROLE) {
                return $response->addData(CompanyRoleResource::make($role))
                    ->toJson();
            }

            return $response->addPopup(new SimpleNotification(trans('response.error.edit.admin.role')))
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
            $response = new Response();

            if ($role->name !== RoleTableMap::MAIN_ROLE) {
                $data = new RoleData(...$request->validated());

                (new UpdateRoleAction($role))($data);

                return $response->addPopup(new SimpleNotification(trans('response.success.update.company.role')))
                    ->toJson();
            }

            return $response->addPopup(
                new SimpleNotification(trans('response.error.update.admin.role')),
                ResponseCodes::HTTP_BAD_REQUEST
            )
                ->toJson();
        }
    }
