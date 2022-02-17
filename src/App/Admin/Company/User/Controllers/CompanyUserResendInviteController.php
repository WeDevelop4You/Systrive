<?php

    namespace App\Admin\Company\User\Controllers;

    use Domain\Company\Models\Company;
    use Domain\Invite\Actions\ResendInviteAction;
    use Domain\Invite\Mappings\InviteTableMap;
    use Domain\User\Models\User;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;

    class CompanyUserResendInviteController
    {
        /**
         * @param Company     $company
         * @param User $user
         *
         * @return JsonResponse
         */
        public function action(Company $company, User $user): JsonResponse
        {
            $invite = $company->invites()
                ->whereInviteByEmailAndCompany($user->email, $company->id, InviteTableMap::USER_TYPE)
                ->first();

            (new ResendInviteAction($company))($invite);

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.invite.resend')))
                ->toJson();
        }
    }
