<?php

    namespace Support\Helpers\Response\Popups\Notifications;

    use Support\Abstracts\Response\NotificationAbstract;

    class SimpleNotification extends NotificationAbstract
    {
        public function getComponent(): string
        {
            return 'SimpleNotification';
        }
    }
