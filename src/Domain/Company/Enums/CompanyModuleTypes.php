<?php

namespace Domain\Company\Enums;

enum CompanyModuleTypes: string
{
    case CMS = 'cms';
    case SYSTEM = 'system';

    /**
     * @return string
     */
    public function trans(): string
    {
        return match ($this) {
            self::CMS => trans('word.cms.cms'),
            self::SYSTEM => trans('word.system.system'),
        };
    }
}
