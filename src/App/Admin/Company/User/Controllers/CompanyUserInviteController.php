<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\Requests\CompanyUserInviteRequest;
    use Domain\Company\Actions\User\InviteUserToCompanyAction;
    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;

    class CompanyUserInviteController
    {
        /**
         * @param CompanyUserInviteRequest $request
         * @param Company                  $company
         *
         * @return JsonResponse
         */
        public function action(CompanyUserInviteRequest $request, Company $company): JsonResponse
        {
            $data = new CompanyUserData(...$request->validated());

            (new InviteUserToCompanyAction($company))($data);

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.company.invite.user')))
                ->toJson();
        }
    }
