<?php

namespace Support\Enums\Component;

enum ModalCloseType
{
    case FAIL;
    case NEVER;
    case ALWAYS;
    case SUCCESS;

    /**
     * @param ModalCloseType $type
     *
     * @return bool
     */
    public static function isSuccess(self $type): bool
    {
        return \in_array($type, [self::SUCCESS, self::ALWAYS]);
    }

    public static function isFail(self $type): bool
    {
        return \in_array($type, [self::FAIL, self::ALWAYS]);
    }
}
