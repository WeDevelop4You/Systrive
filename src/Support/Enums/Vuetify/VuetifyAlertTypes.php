<?php

    namespace Support\Enums\Vuetify;

    enum VuetifyAlertTypes: string
    {
        case INFO = 'info';
        case ERROR = 'error';
        case SUCCESS = 'success';
        case WARNING = 'warning';
    }
