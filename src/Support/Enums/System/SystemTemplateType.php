<?php

    namespace Support\Enums\System;

    enum SystemTemplateType: string
    {
        case WEB = 'web';
        case DNS = 'dns';
        case PROXY = 'proxy';
    }
