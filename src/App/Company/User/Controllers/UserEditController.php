<?php

    namespace App\Company\User\Controllers;

    use App\Company\User\Requests\UserRequest;
    use App\Company\User\Responses\UserEditResponse;
    use Domain\Company\Actions\CompanyUpdateUserPermissionsAction;
    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;
    use Domain\User\Models\User;
    use Illuminate\Http\JsonResponse;
    use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Client\Response;

    class UserEditController
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

            return UserEditResponse::create($company, $user)->toJson();
        }

        /**
         * @param UserRequest $request
         * @param Company     $company
         * @param User        $user
         *
         * @return JsonResponse
         */
        public function action(UserRequest $request, company $company, User $user): JsonResponse
        {
            $data = new CompanyUserData(...$request->validated());
            $data->setUser($user);

            (new CompanyUpdateUserPermissionsAction($company))($data);

            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.saved')))
                ->toJson();
        }
    }
