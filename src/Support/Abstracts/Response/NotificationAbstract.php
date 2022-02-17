<?php

    namespace Support\Abstracts\Response;

    use Support\Abstracts\Response\AbstractPopup;
    use Support\Enums\PopupTypes;
    use Support\Enums\Vuetify\VuetifyAlertTypes;
    use Symfony\Component\HttpFoundation\Response;
    use function trans;

    abstract class NotificationAbstract extends AbstractPopup
    {
        /**
         * @var array
         */
        protected array $message;

        /**
         * @var string
         */
        private string $text;

        /**
         * @var int|null
         */
        private ?int $time = null;

        /**
         * @var bool
         */
        private bool $stayable = false;

        /**
         * @param string $text
         * @param int    $statusCode
         */
        final public function __construct(string $text, int $statusCode = Response::HTTP_OK)
        {
            $this->text = $text;
            $this->setText($text);
            $this->selectedTypeByStatusCode($statusCode);
        }

        /**
         * @return PopupTypes
         */
        public function getType(): PopupTypes
        {
            return PopupTypes::NOTIFICATION;
        }

        /**
         * @return $this
         */
        private function setText(?string $text = null): AbstractPopup
        {
            $this->message['text'] = $text ?? $this->text;

            return $this;
        }

        /**
         * @param VuetifyAlertTypes $type
         *
         * @return AbstractPopup
         */
        final public function setMessageType(VuetifyAlertTypes $type): AbstractPopup
        {
            $this->message['type'] = $type->value;

            return $this;
        }

        /**
         * @param string $icon
         *
         * @return AbstractPopup
         */
        final public function setIcon(string $icon): AbstractPopup
        {
            $this->message['icon'] = $icon;

            return $this;
        }

        /**
         * @param string $color
         *
         * @return AbstractPopup
         */
        final public function setColor(string $color): AbstractPopup
        {
            $this->message['color'] = $color;

            return $this;
        }

        /**
         * @param int $time
         *
         * @return AbstractPopup
         */
        final public function setTime(int $time): AbstractPopup
        {
            $this->time = $time;

            return $this;
        }

        /**
         * @return AbstractPopup
         */
        final public function setStayable(): AbstractPopup
        {
            $this->stayable = true;

            return $this;
        }

        /**
         * @param string ...$links
         *
         * @return AbstractPopup
         */
        final public function insertLinkInText(string ...$links): AbstractPopup
        {
            foreach ($links as $link) {
                $htmlLink = "<a class='text--primary' href='{$link}' $1>$2</a>";
                $this->text = preg_replace('\[(.*)?<(s?.*?s?)>]', $htmlLink, $this->text);
            }

            return $this->setText();
        }

        public function selectedTypeByStatusCode(int $statusCode)
        {
            switch ($statusCode) {
                case 200:
                case 201:
                case 204:
                    $this->setMessageType(VuetifyAlertTypes::SUCCESS);

                    break;
                case 403:
                    $this->setMessageType(VuetifyAlertTypes::WARNING);

                    break;
                case 400:
                case 401:
                case 404:
                case 422:
                    $this->setMessageType(VuetifyAlertTypes::ERROR);

                    break;
                default:
                    $this->setMessageType(VuetifyAlertTypes::INFO);
                    $this->setText(trans('response.unknown.status_code'));
            }
        }

        /**
         * @return array
         */
        final public function getData(): array
        {
            return [
                'time' => $this->time,
                'message' => $this->message,
                'stayable' => $this->stayable,
            ];
        }
    }
