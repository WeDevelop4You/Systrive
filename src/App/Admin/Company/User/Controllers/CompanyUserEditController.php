<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\Requests\CompanyUserUpdateRequest;
    use App\Admin\Company\User\Responses\CompanyUserEditResponse;
    use Domain\Company\Actions\CompanyUserUpdatePermissionsAction;
    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;
    use Domain\User\Models\User;
    use Illuminate\Http\JsonResponse;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;

    class CompanyUserEditController
    {
        /**
         * @param Company $company
         * @param User    $user
         *
         * @return JsonResponse
         */
        public function index(Company $company, User $user): JsonResponse
        {
            setPermissionsTeamId($company->id);

            return CompanyUserEditResponse::create($company, $user)->toJson();
        }

        /**
         * @param CompanyUserUpdateRequest $request
         * @param Company                  $company
         * @param User                     $user
         *
         * @return JsonResponse
         */
        public function action(CompanyUserUpdateRequest $request, company $company, User $user): JsonResponse
        {
            $data = new CompanyUserData(...$request->validated());

            (new CompanyUserUpdatePermissionsAction($company, $user))($data);

            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.saved')))
                ->toJson();
        }
    }
