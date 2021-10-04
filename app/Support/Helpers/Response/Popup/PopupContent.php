<?php

    namespace Support\Helpers\Response\Popup;

    class PopupContent
    {
        public const SIMPLE_TYPE = 'Simple';

        private array $content;

        /**
         * @var PopupMessageBase
         */
        public PopupMessageBase $message;

        /**
         * @param string $message
         * @param int $statusCode
         * @param string $component
         */
        public function __construct(string $message, int $statusCode, string $component = self::SIMPLE_TYPE)
        {
            $messageClass = __namespace__ . "\\Messages\\{$component}Message";

            $this->setComponent($component);
            $this->message = new $messageClass($message, $statusCode);
        }

        /**
         * @param $component
         * @return $this
         */
        public function setComponent($component): PopupContent
        {
            $this->content['component'] = $component;

            return $this;
        }

        /**
         * @param int $time
         * @return $this
         */
        public function setTime(int $time): PopupContent
        {
            $this->content['time'] = $time;

            return $this;
        }

        public function setStayable(): PopupContent
        {
            $this->content['stayable'] = true;

            return $this;
        }

        public function create(): array
        {
            $this->content['message'] = $this->message->data;

            return $this->content;
        }
    }
