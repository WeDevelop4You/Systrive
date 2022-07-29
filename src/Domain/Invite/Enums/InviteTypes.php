<?php

namespace Domain\Invite\Enums;

use Domain\Company\Models\CompanyUser;
use Domain\Company\states\CompanyStates;
use Domain\Company\states\CompanyUserStates;
use Domain\Invite\Jobs\SendCompanyInvite;
use Domain\Invite\Jobs\SendInviteToUser;
use Domain\Invite\Models\Invite;

enum InviteTypes: string
{
    case USER = 'user';
    case COMPANY = 'company';

    public function getStatus(Invite $invite): CompanyUserStates|CompanyStates
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
     * @return CompanyUserStates
     */
    private function getCompanyUserStatus(Invite $invite): CompanyUserStates
    {
        return CompanyUser::firstWithInvite($invite)->status->getState($invite);
    }

    /**
     * @param Invite $invite
     *
     * @return CompanyStates
     */
    private function getCompanyStatus(Invite $invite): CompanyStates
    {
        return $invite->company->status->getState($invite);
    }
}
