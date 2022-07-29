<?php

    namespace Support\Enums\System;

    enum SystemTemplateTypes: string
    {
        case WEB = 'web';
        case DNS = 'dns';
        case PROXY = 'proxy';
    }
