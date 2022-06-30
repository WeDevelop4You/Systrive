<?php

namespace Domain\Git\Enums;

use Support\Enums\IconTypes;

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
     * @return IconTypes
     */
    public function icon(): IconTypes
    {
        return match ($this) {
            self::GITHUB => IconTypes::FAB_GITHUB,
            self::GITLAB => IconTypes::FAB_GITLAB,
        };
    }
}
