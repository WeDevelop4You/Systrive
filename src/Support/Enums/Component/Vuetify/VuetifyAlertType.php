<?php

    namespace Support\Enums\Component\Vuetify;

    enum VuetifyAlertType: string
    {
        case INFO = 'info';
        case ERROR = 'error';
        case SUCCESS = 'success';
        case WARNING = 'warning';
    }
