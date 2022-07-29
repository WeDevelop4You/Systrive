<?php

    namespace App\Admin\Company\Controllers;

    use Domain\Company\Models\Company;
    use Domain\Invite\Models\Invite;
    use Illuminate\Http\JsonResponse;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;

    class CompanyResendInviteController
    {
        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function action(Company $company): JsonResponse
        {
            /** @var invite $invite */
            $invite = $company->invites()->whereCompanyType()->first();

            $invite->type->sendInvite($invite);

            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.invite.resend')))
                ->toJson();
        }
    }
