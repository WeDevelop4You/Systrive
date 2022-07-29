<?php

    namespace App\Admin\Company\User\Controllers;

    use Domain\Company\Models\Company;
    use Domain\Invite\Jobs\SendInviteToUser;
    use Domain\Invite\Models\Invite;
    use Domain\User\Models\User;
    use Illuminate\Http\JsonResponse;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;

    class CompanyUserResendInviteController
    {
        /**
         * @param Company $company
         * @param User    $user
         *
         * @return JsonResponse
         */
        public function action(Company $company, User $user): JsonResponse
        {
            $invite = $company->invites()
                ->whereInviteByUserAndCompany($user, $company)
                ->whereUserType()
                ->first();

            if ($invite instanceof Invite) {
                $invite->type->sendInvite($invite);
            } else {
                SendInviteToUser::dispatch($user, $company);
            }

            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.invite.resend')))
                ->toJson();
        }
    }
