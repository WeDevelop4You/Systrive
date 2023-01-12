<?php

namespace Support\Enums\Component;

enum TargetType: string
{
    case BLANK = '_blank';
    case SELF = '_self';
    case parent = '_parent';
    case TOP = '_top';
}
