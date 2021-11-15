<?php

    namespace Support\Helpers\Response\Popup;

    abstract class PopupMessageBase
    {
        public const INFO_TYPE = 'info';
        public const ERROR_TYPE = 'error';
        public const SUCCESS_TYPE = 'success';
        public const WARNING_TYPE = 'warning';

        /**
         * @var array
         */
        private array $data;

        /**
         * @var string
         */
        private string $text;

        /**
         * @param string $text
         * @param int    $statusCode
         */
        final public function __construct(string $text, int $statusCode)
        {
            $this->text = $text;
            $this->setText($text);
            $this->selectedTypeByStatusCode($statusCode);
        }

        /**
         * @return $this
         */
        private function setText(?string $text = null): PopupMessageBase
        {
            $this->data['text'] = $text ?? $this->text;

            return $this;
        }

        /**
         * @param string $type
         *
         * @return PopupMessageBase
         */
        final public function setType(string $type): PopupMessageBase
        {
            $this->data['type'] = $type;

            return $this;
        }

        /**
         * @param string $icon
         *
         * @return PopupMessageBase
         */
        final public function setIcon(string $icon): PopupMessageBase
        {
            $this->data['icon'] = $icon;

            return $this;
        }

        /**
         * @param string $color
         *
         * @return PopupMessageBase
         */
        final public function setColor(string $color): PopupMessageBase
        {
            $this->data['color'] = $color;

            return $this;
        }

        /**
         * @param string ...$links
         *
         * @return PopupMessageBase
         */
        final public function insertLinkInChat(string ...$links): PopupMessageBase
        {
            foreach ($links as $link) {
                $htmlLink = "<a class='text--primary' href='{$link}' $1>$2</a>";
                $this->text = preg_replace('\[(.*)?<(s?.*?s?)>]', $htmlLink, $this->text);
            }

            return $this->setText();
        }

        /**
         * @return array
         */
        final public function getData(): array
        {
            return $this->data;
        }

        private function selectedTypeByStatusCode(int $statusCode)
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
    }
