<?php

namespace Domain\Git\Enums;

use Support\Enums\Component\IconType;

enum GitServiceTypes: string
{
    case GITHUB = 'github';
    case GITLAB = 'gitlab';

    /**
     * @return string[]
     */
    public function scopes(): array
    {
        return match ($this) {
            self::GITHUB => ['user:email', 'repo'],
            self::GITLAB => ['read_user', 'read_api', 'read_repository'],
        };
    }

    /**
     * @return IconType
     */
    public function icon(): IconType
    {
        return match ($this) {
            self::GITHUB => IconType::FAB_GITHUB,
            self::GITLAB => IconType::FAB_GITLAB,
        };
    }
}
