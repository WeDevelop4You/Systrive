<?php

namespace Domain\Company\Enums;

use Domain\Company\states\CompanyUserAcceptedState;
use Domain\Company\states\CompanyUserExpiredState;
use Domain\Company\states\CompanyUserRequestedState;
use Domain\Company\states\CompanyUserStates;
use Domain\Invite\Models\Invite;
use Support\Enums\Component\Vuetify\VuetifyColors;
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
     * @return CompanyUserStates
     */
    public function getState(Invite $invite): CompanyUserStates
    {
        return match ($this) {
            self::REQUESTED => new CompanyUserRequestedState($invite),
            self::EXPIRED => new CompanyUserExpiredState($invite),
            self::ACCEPTED => new CompanyUserAcceptedState($invite),
        };
    }

    public function getColor(): VuetifyColors
    {
        return match ($this) {
            self::REQUESTED => VuetifyColors::INFO,
            self::EXPIRED => VuetifyColors::WARNING,
            self::ACCEPTED => VuetifyColors::SUCCESS,
        };
    }
}
