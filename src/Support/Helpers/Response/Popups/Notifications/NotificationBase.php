<?php

    namespace Support\Helpers\Response\Popups\Notifications;

    use Support\Helpers\Response\Popups\PopupBase;
    use Symfony\Component\HttpFoundation\Response;

    abstract class NotificationBase extends PopupBase
    {
        public const INFO_TYPE = 'info';
        public const ERROR_TYPE = 'error';
        public const SUCCESS_TYPE = 'success';
        public const WARNING_TYPE = 'warning';

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
         * @param mixed ...$data
         *
         * @return static
         */
        public static function create(...$data): static
        {
            return new static(...$data);
        }

        /**
         * @return string
         */
        public function getType(): string
        {
            return self::NOTIFICATION_TYPE;
        }

        /**
         * @return $this
         */
        private function setText(?string $text = null): PopupBase
        {
            $this->message['text'] = $text ?? $this->text;

            return $this;
        }

        /**
         * @param string $type
         *
         * @return PopupBase
         */
        final public function setType(string $type): PopupBase
        {
            $this->message['type'] = $type;

            return $this;
        }

        /**
         * @param string $icon
         *
         * @return PopupBase
         */
        final public function setIcon(string $icon): PopupBase
        {
            $this->message['icon'] = $icon;

            return $this;
        }

        /**
         * @param string $color
         *
         * @return PopupBase
         */
        final public function setColor(string $color): PopupBase
        {
            $this->message['color'] = $color;

            return $this;
        }

        /**
         * @param int $time
         *
         * @return PopupBase
         */
        final public function setTime(int $time): PopupBase
        {
            $this->time = $time;

            return $this;
        }

        /**
         * @return PopupBase
         */
        final public function setStayable(): PopupBase
        {
            $this->stayable = true;

            return $this;
        }

        /**
         * @param string ...$links
         *
         * @return PopupBase
         */
        final public function insertLinkInText(string ...$links): PopupBase
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
                    $this->setType(self::SUCCESS_TYPE);

                    break;
                case 403:
                    $this->setType(self::WARNING_TYPE);

                    break;
                case 400:
                case 401:
                case 404:
                case 422:
                    $this->setType(self::ERROR_TYPE);

                    break;
                default:
                    $this->setType(self::INFO_TYPE);
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
