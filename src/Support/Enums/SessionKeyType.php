<?php

namespace Support\Enums;

enum SessionKeyType: string
{
    case KEEP = 'response_session_data_keep';
    case ONCE = 'response_session_data_once';
    case REGISTRATION = 'registration_session_data';
}
