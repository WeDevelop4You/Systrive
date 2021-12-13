<?php

    namespace App\Admin\Company\Role\Controllers;

    use App\Admin\Company\Role\Requests\CompanyRoleRequest;
    use Domain\Company\Models\Company;
    use Domain\Role\Actions\CreateRoleAction;
    use Domain\Role\DataTransferObjects\RoleData;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;

    class CompanyRoleCreateController
    {
        /**
         * @param CompanyRoleRequest $requests
         * @param Company            $company
         *
         * @return JsonResponse
         */
        public function action(CompanyRoleRequest $requests, Company $company): JsonResponse
        {
            $data = new RoleData(...$requests->validated());

            (new CreateRoleAction($company))($data);

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.create.company.role')))
                ->toJson();
        }
    }
