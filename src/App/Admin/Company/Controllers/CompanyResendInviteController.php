<?php

    namespace App\Admin\Company\Controllers;

    use Domain\Company\Models\Company;
    use Domain\Invite\Actions\ResendInviteAction;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;

    class CompanyResendInviteController
    {
        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function action(Company $company): JsonResponse
        {
            $invite = $company->invites()->whereCompanyType()->first();

            (new ResendInviteAction($company))($invite);

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.invite.resend')))
                ->toJson();
        }
    }
