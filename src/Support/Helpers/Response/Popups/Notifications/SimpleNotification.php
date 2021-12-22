<?php

    namespace Support\Helpers\Response\Popups\Notifications;

    class SimpleNotification extends NotificationBase
    {
        public function getComponent(): string
        {
            return 'SimpleNotification';
        }
    }
