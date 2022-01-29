<?php

    namespace Support\Helpers\Response\Popups;

    use Illuminate\Support\Str;

    class PopupContent
    {
        private array $content;

        /**
         * @param PopupBase $instance
         */
        public function __construct(
            public PopupBase $instance
        ) {
            $this->setId();
            $this->setType($instance->getType());
            $this->setComponent($instance->getComponent());
        }

        /**
         * @param PopupBase $instance
         *
         * @return PopupContent
         */
        public static function create(PopupBase $instance): PopupContent
        {
            return new static($instance);
        }

        private function setId()
        {
            $this->content['id'] = Str::uuid();
        }

        /**
         * @param string $type
         */
        private function setType(string $type): void
        {
            $this->content['type'] = $type;
        }

        /**
         * @param $component
         */
        private function setComponent($component): void
        {
            $this->content['component'] = $component;
        }

        public function getData(): array
        {
            $this->content['data'] = $this->instance->getData();

            return $this->content;
        }
    }
