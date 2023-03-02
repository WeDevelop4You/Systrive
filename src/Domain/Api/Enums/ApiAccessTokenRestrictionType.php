<?php

namespace Domain\Api\Enums;

enum ApiAccessTokenRestrictionType: int
{
    case NONE = 0;
    case DOMAIN = 1;
    case IP = 2;
}
