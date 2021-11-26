<?php

    namespace Support\Helpers\Response\Popup\Messages;

    use Support\Helpers\Response\Popup\PopupMessageBase;

    class SimpleMessage extends PopupMessageBase
    {
        public static function getComponent(): string
        {
            return 'Simple';
        }
    }
