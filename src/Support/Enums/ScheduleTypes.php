<?php

namespace Support\Enums;

use Support\Traits\DatabaseEnumSearch;

enum ScheduleTypes: int
{
    use DatabaseEnumSearch;

    case SYSTEM_DATA = 0;
    case SYSTEM_TEMPLATES = 1;

    /**
     * @return array
     */
    public static function getTranslations(): array
    {
        return [
            self::SYSTEM_DATA->value => trans('word.system.data'),
            self::SYSTEM_TEMPLATES->value => trans('word.system.templates'),
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return match ($this) {
            self::SYSTEM_DATA => 'System data',
            self::SYSTEM_TEMPLATES => 'System templates',
        };
    }
}
