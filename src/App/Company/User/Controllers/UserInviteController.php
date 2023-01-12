<?php

    namespace App\Company\User\Controllers;

    use App\Company\User\Requests\UserRequest;
    use App\Company\User\Responses\UserInviteResponse;
    use Domain\Company\Actions\CompanyInviteUserAction;
    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Client\Response;

    class UserInviteController
    {
        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function index(Company $company): JsonResponse
        {
            return UserInviteResponse::create($company)->toJson();
        }

        /**
         * @param UserRequest $request
         * @param Company     $company
         *
         * @return JsonResponse
         */
        public function action(UserRequest $request, Company $company): JsonResponse
        {
            $data = new CompanyUserData(...$request->validated());

            (new CompanyInviteUserAction($company))($data);

            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()
                        ->setText(trans('response.success.company.invite.user'))
                )
                ->toJson();
        }
    }
