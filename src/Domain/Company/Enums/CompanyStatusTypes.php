<?php

namespace Domain\Company\Enums;

use Domain\Company\states\AbstractCompanyState;
use Domain\Company\states\CompanyCompletedState;
use Domain\Company\states\CompanyExpiredState;
use Domain\Company\states\CompanyInvitedState;
use Domain\Invite\Models\Invite;
use Support\Enums\Component\Vuetify\VuetifyColor;
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
     * @return AbstractCompanyState
     */
    public function getState(Invite $invite): AbstractCompanyState
    {
        return match ($this) {
            self::INVITED => new CompanyInvitedState($invite),
            self::EXPIRED => new CompanyExpiredState($invite),
            self::COMPLETED => new CompanyCompletedState($invite),
        };
    }

    /**
     * @return VuetifyColor
     */
    public function getColor(): VuetifyColor
    {
        return match ($this) {
            self::INVITED => VuetifyColor::INFO,
            self::EXPIRED => VuetifyColor::WARNING,
            self::COMPLETED => VuetifyColor::SUCCESS,
        };
    }
}
