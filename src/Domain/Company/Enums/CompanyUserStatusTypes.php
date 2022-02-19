<?php

namespace Domain\Company\Enums;

use Support\Traits\DatabaseEnumSearch;

enum CompanyUserStatusTypes: int
{
    use DatabaseEnumSearch;

    case REQUESTED = 0;
    case EXPIRED = 1;
    case ACCEPTED = 2;

    public static function getTranslations(): array
    {
        return [
              self::REQUESTED->value => trans('database.company.user.requested'),
              self::EXPIRED->value => trans('database.company.user.expired'),
              self::ACCEPTED->value => trans('database.company.user.accepted'),
        ];
    }
}
