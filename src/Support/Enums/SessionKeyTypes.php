<?php

    namespace Support\Enums;

    enum SessionKeyTypes: string
    {
        case KEEP = 'session_get';
        case ONCE = 'session_pull';
        case REGISTRATION = 'session_registration';
    }
