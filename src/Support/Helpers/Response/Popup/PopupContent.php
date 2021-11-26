<?php

    namespace Support\Helpers\Response\Popup;

    use Support\Helpers\Response\Popup\Messages\SimpleMessage;

    class PopupContent
    {
        public const SIMPLE_TYPE = SimpleMessage::class;

        private array $content;

        /**
         * @var PopupMessageBase
         */
        public PopupMessageBase $message;

        /**
         * @param string $message
         * @param int    $statusCode
         * @param string $class
         */
        public function __construct(string $message, int $statusCode, string $class = self::SIMPLE_TYPE)
        {
            $this->message = new $class($message, $statusCode);
            $this->setComponent(call_user_func([$class, 'getComponent']));
        }

        /**
         * @param $component
         *
         * @return $this
         */
        public function setComponent($component): PopupContent
        {
            $this->content['component'] = $component;

            return $this;
        }

        /**
         * @param int $time
         *
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
            $this->content['message'] = $this->message->getData();

            return $this->content;
        }
    }
