<?php

namespace Domain\User\Enums;

enum UserPreferences: string
{
    case DARK_MODE = 'dark_mode';

    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function validate($value): bool
    {
        return match ($this) {
            self::DARK_MODE => \is_bool($value),
        };
    }
}
