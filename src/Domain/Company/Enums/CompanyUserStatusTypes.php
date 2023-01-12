<?php

namespace Domain\Company\Enums;

use Domain\Company\states\AbstractCompanyUserState;
use Domain\Company\states\CompanyUserAcceptedState;
use Domain\Company\states\CompanyUserExpiredState;
use Domain\Company\states\CompanyUserRequestedState;
use Domain\Invite\Models\Invite;
use Illuminate\Support\Arr;
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
              self::REQUESTED->value => trans('word.company.user.requested'),
              self::EXPIRED->value => trans('word.company.user.expired'),
              self::ACCEPTED->value => trans('word.company.user.accepted'),
        ];
    }

    /**
     * @return string
     */
    public function getTranslation(): string
    {
        return Arr::get(self::getTranslations(), $this->value, '');
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
