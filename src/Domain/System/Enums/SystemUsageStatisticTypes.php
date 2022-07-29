<?php

namespace Domain\System\Enums;

enum SystemUsageStatisticTypes: string
{
    case DISK = 'disk';
    case BANDWIDTH = 'bandwidth';
}
