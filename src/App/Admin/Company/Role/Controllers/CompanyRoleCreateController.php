<?php

    namespace App\Admin\Company\Role\Controllers;

    use App\Admin\Company\Role\Requests\CompanyRoleRequest;
    use App\Admin\Company\Role\Responses\CompanyRoleCreateResponse;
    use Domain\Company\Models\Company;
    use Domain\Role\Actions\CreateRoleAction;
    use Domain\Role\DataTransferObjects\RoleData;
    use Illuminate\Http\JsonResponse;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;

    class CompanyRoleCreateController
    {
        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function index(Company $company): JsonResponse
        {
            return CompanyRoleCreateResponse::create($company)->toJson();
        }

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
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.saved')))
                ->toJson();
        }
    }
