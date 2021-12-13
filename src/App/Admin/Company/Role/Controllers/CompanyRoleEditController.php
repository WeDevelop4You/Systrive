<?php

    namespace App\Admin\Company\Role\Controllers;

    use App\Admin\Company\Role\Requests\CompanyRoleRequest;
    use App\Admin\Company\Role\Resources\CompanyRoleResource;
    use Domain\Company\Models\Company;
    use Domain\Role\Actions\UpdateRoleAction;
    use Domain\Role\DataTransferObjects\RoleData;
    use Illuminate\Http\JsonResponse;
    use Spatie\Permission\Models\Role;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;

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
            return Response::create()
                ->addData(CompanyRoleResource::make($role))
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
            $data = new RoleData(...$request->validated());

            (new UpdateRoleAction($role))($data);

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.update.company.role')))
                ->toJson();
        }
    }
