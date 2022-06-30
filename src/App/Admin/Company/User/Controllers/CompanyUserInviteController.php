<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\Requests\CompanyUserInviteRequest;
    use App\Admin\Company\User\Responses\CompanyUserInviteResponse;
    use Domain\Company\Actions\CreateCompanyUserInviteAction;
    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;

    class CompanyUserInviteController
    {
        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function index(Company $company): JsonResponse
        {
            return CompanyUserInviteResponse::create($company)->toJson();
        }

        /**
         * @param CompanyUserInviteRequest $request
         * @param Company                  $company
         *
         * @return JsonResponse
         */
        public function action(CompanyUserInviteRequest $request, Company $company): JsonResponse
        {
            $data = new CompanyUserData(...$request->validated());

            (new CreateCompanyUserInviteAction($company))($data);

            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()
                        ->setText(trans('response.success.company.invite.user'))
                )
                ->toJson();
        }
    }
