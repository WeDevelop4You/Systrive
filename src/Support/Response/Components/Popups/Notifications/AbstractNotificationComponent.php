<?php

    namespace Support\Response\Components\Popups\Notifications;

    use Support\Enums\IconTypes;
    use Support\Enums\PopupTypes;
    use Support\Enums\Vuetify\VuetifyAlertTypes;
    use Support\Response\Components\Popups\AbstractPopupComponent;
    use Symfony\Component\HttpFoundation\Response;
    use function trans;

    abstract class AbstractNotificationComponent extends AbstractPopupComponent
    {
        /**
         * @var string
         */
        private string $text;

        protected function __construct()
        {
            parent::__construct();

            $this->setStayable(false);
            $this->setAlertTypeByStatusCode(Response::HTTP_OK);
        }

        /**
         * @return PopupTypes
         */
        protected function getType(): PopupTypes
        {
            return PopupTypes::NOTIFICATION;
        }

        /**
         * @param string $text
         *
         * @return $this
         */
        public function setText(string $text): AbstractPopupComponent
        {
            $this->text = $text;

            return $this->setContent('text', $text);
        }

        /**
         * @param VuetifyAlertTypes $type
         *
         * @return AbstractPopupComponent
         */
        public function setAlertType(VuetifyAlertTypes $type): AbstractPopupComponent
        {
            return $this->setAttribute('type', $type->value);
        }

        /**
         * @param IconTypes $icon
         *
         * @return AbstractPopupComponent
         */
        public function setIcon(IconTypes $icon): AbstractPopupComponent
        {
            return $this->setAttribute('icon', $icon->value);
        }

        /**
         * @param string $color
         *
         * @return AbstractPopupComponent
         */
        final public function setColor(string $color): AbstractPopupComponent
        {
            return $this->setAttribute('color', $color);
        }

        /**
         * @param int $time
         *
         * @return AbstractPopupComponent
         */
        public function setTime(int $time): AbstractPopupComponent
        {
            $this->setData('time', $time);

            return $this;
        }

        /**
         * @param bool $value
         *
         * @return AbstractPopupComponent
         */
        public function setStayable(bool $value = true): AbstractPopupComponent
        {
            return $this->setData('stayable', $value);
        }

        /**
         * @param string ...$links
         *
         * @return AbstractPopupComponent
         */
        public function insertLinkInText(string ...$links): AbstractPopupComponent
        {
            $text = $this->text;

            foreach ($links as $link) {
                $htmlLink = "<a class='text--primary' href='{$link}' $1>$2</a>";
                $text = preg_replace('\[(.*)?<(s?.*?s?)>]', $htmlLink, $text);
            }

            return $this->setText($text);
        }

        public function setAlertTypeByStatusCode(int $statusCode)
        {
            switch ($statusCode) {
                case 200:
                case 201:
                case 204:
                    $this->setAlertType(VuetifyAlertTypes::SUCCESS);

                    break;
                case 403:
                    $this->setAlertType(VuetifyAlertTypes::WARNING);

                    break;
                case 400:
                case 401:
                case 404:
                case 422:
                    $this->setAlertType(VuetifyAlertTypes::ERROR);

                    break;
                default:
                    $this->setAlertType(VuetifyAlertTypes::INFO);
                    $this->setText(trans('response.unknown.status_code'));
            }
        }
    }
