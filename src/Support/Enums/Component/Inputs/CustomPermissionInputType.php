<?php

namespace Support\Enums\Component\Inputs;

enum CustomPermissionInputType: string implements CustomInputType
{
    case USER = 'PermissionUserInputComponent';
    case ROLE = 'PermissionRoleInputComponent';
}
