<?php

    namespace App\Admin\Company\User\Controllers;

    use Domain\Company\Actions\RevokeUserFromCompanyAction;
    use Domain\Company\Models\Company;
    use Domain\User\Models\User;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;

    class CompanyUserRevokeController
    {
        /**
         * @param Company $company
         * @param User    $user
         *
         * @return JsonResponse
         */
        public function action(Company $company, User $user): JsonResponse
        {
            (new RevokeUserFromCompanyAction($company))($user);

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.revoke.user.company')))
                ->toJson();
        }
    }
