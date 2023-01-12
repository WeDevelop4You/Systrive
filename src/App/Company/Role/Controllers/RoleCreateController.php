<?php

    namespace App\Company\Role\Controllers;

    use App\Company\Role\Requests\RoleRequest;
    use App\Company\Role\Responses\RoleCreateResponse;
    use Domain\Company\Models\Company;
    use Domain\Role\Actions\CreateRoleAction;
    use Domain\Role\DataTransferObjects\RoleData;
    use Illuminate\Http\JsonResponse;
    use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Client\Response;

    class RoleCreateController
    {
        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function index(Company $company): JsonResponse
        {
            return RoleCreateResponse::create($company)->toJson();
        }

        /**
         * @param RoleRequest $requests
         * @param Company     $company
         *
         * @return JsonResponse
         */
        public function action(RoleRequest $requests, Company $company): JsonResponse
        {
            $data = new RoleData(...$requests->validated());

            (new CreateRoleAction($company))($data);

            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.saved')))
                ->toJson();
        }
    }
