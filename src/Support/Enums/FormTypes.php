<?php

    namespace Support\Enums;

    enum FormTypes: string
    {
        case TESTING = '';
        case COMPANY = 'CompanyForm';
        case PASSWORD = 'PasswordForm';
        case TRANSLATION = 'TranslationForm';
        case COMPANY_USER = 'CompanyUserForm';
        case COMPANY_ROLE = 'CompanyRoleForm';
        case USER_PROFILE = 'UserProfileForm';
        case RECOVERY_CODE = 'RecoveryCodeForm';
        case COMPANY_COMPLETE = 'CompanyCompleteForm';
        case ONE_TIME_PASSWORD = 'OneTimePasswordValidateForm';
        case ONE_TIME_PASSWORD_ENABLE = 'OneTimePasswordEnableForm';
    }
