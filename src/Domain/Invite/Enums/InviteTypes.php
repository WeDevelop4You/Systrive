<?php

namespace Domain\Invite\Enums;

use Domain\Company\Models\CompanyUser;
use Domain\Company\States\AbstractCompanyState;
use Domain\Company\States\AbstractCompanyUserState;
use Domain\Invite\Jobs\SendCompanyInvite;
use Domain\Invite\Jobs\SendInviteToUser;
use Domain\Invite\Models\Invite;

enum InviteTypes: string
{
    case USER = 'user';
    case COMPANY = 'company';

    public function getState(Invite $invite): AbstractCompanyUserState|AbstractCompanyState
    {
        return match ($this) {
            self::USER => $this->getCompanyUserStatus($invite),
            self::COMPANY => $this->getCompanyStatus($invite),
        };
    }

    /**
     * @param Invite $invite
     *
     * @return void
     */
    public function sendInvite(Invite $invite): void
    {
        match ($this) {
            self::USER => SendInviteToUser::dispatch($invite->user, $invite->company),
            self::COMPANY => SendCompanyInvite::dispatch($invite->user, $invite->company),
        };
    }

    /**
     * @param Invite $invite
     *
     * @return AbstractCompanyUserState
     */
    private function getCompanyUserStatus(Invite $invite): AbstractCompanyUserState
    {
        return CompanyUser::firstWithInvite($invite)->status->getState($invite);
    }

    /**
     * @param Invite $invite
     *
     * @return AbstractCompanyState
     */
    private function getCompanyStatus(Invite $invite): AbstractCompanyState
    {
        return $invite->company->status->getState($invite);
    }
}
