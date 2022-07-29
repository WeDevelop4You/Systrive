<?php

namespace Domain\Company\Enums;

use Domain\Company\states\CompanyCompletedState;
use Domain\Company\states\CompanyExpiredState;
use Domain\Company\states\CompanyInvitedState;
use Domain\Company\states\CompanyStates;
use Domain\Invite\Models\Invite;
use Support\Enums\Component\Vuetify\VuetifyColors;
use Support\Traits\DatabaseEnumSearch;

enum CompanyStatusTypes: int
{
    use DatabaseEnumSearch;

    case INVITED = 0;
    case EXPIRED = 1;
    case COMPLETED = 2;

    public static function getTranslations(): array
    {
        return [
              self::INVITED->value => trans('database.company.invited'),
              self::EXPIRED->value => trans('database.company.expired'),
              self::COMPLETED->value => trans('database.company.completed'),
        ];
    }

    /**
     * @param Invite $invite
     *
     * @return CompanyStates
     */
    public function getState(Invite $invite): CompanyStates
    {
        return match ($this) {
            self::INVITED => new CompanyInvitedState($invite),
            self::EXPIRED => new CompanyExpiredState($invite),
            self::COMPLETED => new CompanyCompletedState($invite),
        };
    }

    public function getColor()
    {
        return match ($this) {
            self::INVITED => VuetifyColors::INFO,
            self::EXPIRED => VuetifyColors::WARNING,
            self::COMPLETED => VuetifyColors::SUCCESS,
        };
    }
}
