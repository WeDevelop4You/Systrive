<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\Responses\CompanyUserRevokeConfirmResponse;
    use Domain\Company\Actions\CompanyUserRevokeAction;
    use Domain\Company\Models\Company;
    use Domain\User\Models\User;
    use Illuminate\Http\JsonResponse;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;

    class CompanyUserRevokeController
    {
        /**
         * @param Company $company
         * @param User    $user
         *
         * @return JsonResponse
         */
        public function index(Company $company, User $user): JsonResponse
        {
            return CompanyUserRevokeConfirmResponse::create($company, $user)
                ->toJson();
        }

        /**
         * @param Company $company
         * @param User    $user
         *
         * @return JsonResponse
         */
        public function action(Company $company, User $user): JsonResponse
        {
            (new CompanyUserRevokeAction($company))($user);

            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.deleted')))
                ->toJson();
        }
    }
