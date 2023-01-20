<?php

namespace App\Company\User\Controllers;

use Domain\Company\Models\Company;
use Domain\Invite\Jobs\SendInviteToUser;
use Domain\Invite\Mappings\InviteTableMap;
use Domain\Invite\Models\Invite;
use Domain\User\Models\User;
use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;

class UserResendInviteController
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
            ->where(InviteTableMap::COL_USER_ID, $user->id)
            ->whereUserType()
            ->first();

        if ($invite instanceof Invite) {
            $invite->send();
        } else {
            SendInviteToUser::dispatch($user, $company);
        }

        return Response::create()
            ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.invite.resend')))
            ->toJson();
    }
}
