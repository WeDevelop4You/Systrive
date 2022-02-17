<?php

    namespace Support\Enums;

    enum FormTypes: string
    {
        case COMPANY = 'Company';
        case RECOVERY_CODE = 'RecoveryCode';
        case ONE_TIME_PASSWORD = 'OneTimePassword';
    }
