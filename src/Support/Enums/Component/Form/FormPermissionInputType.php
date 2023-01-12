<?php

namespace Support\Enums\Component\Form;

enum FormPermissionInputType: string
{
    case USER = 'PermissionUserInputComponent';
    case ROLE = 'PermissionRoleInputComponent';
}
