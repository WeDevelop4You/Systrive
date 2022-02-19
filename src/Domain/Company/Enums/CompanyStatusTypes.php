<?php

namespace Domain\Company\Enums;

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
}
