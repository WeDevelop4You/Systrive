<?php

namespace Domain\Company\Enums;

use Domain\Company\States\AbstractCompanyUserState;
use Domain\Company\States\CompanyUserAcceptedState;
use Domain\Company\States\CompanyUserExpiredState;
use Domain\Company\States\CompanyUserRequestedState;
use Domain\Invite\Models\Invite;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Traits\DatabaseEnumSearch;

enum CompanyUserStatusTypes: int
{
    use DatabaseEnumSearch;

    case REQUESTED = 0;
    case EXPIRED = 1;
    case ACCEPTED = 2;

    /**
     * @return array
     */
    public static function getTranslations(): array
    {
        return [
              self::REQUESTED->value => trans('database.company.user.requested'),
              self::EXPIRED->value => trans('database.company.user.expired'),
              self::ACCEPTED->value => trans('database.company.user.accepted'),
        ];
    }

    /**
     * @param Invite $invite
     *
     * @return AbstractCompanyUserState
     */
    public function getState(Invite $invite): AbstractCompanyUserState
    {
        return match ($this) {
            self::REQUESTED => new CompanyUserRequestedState($invite),
            self::EXPIRED => new CompanyUserExpiredState($invite),
            self::ACCEPTED => new CompanyUserAcceptedState($invite),
        };
    }

    public function getColor(): VuetifyColor
    {
        return match ($this) {
            self::REQUESTED => VuetifyColor::INFO,
            self::EXPIRED => VuetifyColor::WARNING,
            self::ACCEPTED => VuetifyColor::SUCCESS,
        };
    }
}
