<?php

    namespace Support\Helpers\Response\Popups\Components;

    class Button
    {
        /**
         * @var string
         */
        private string $title;

        /**
         * @var string|null
         */
        private ?string $type = null;

        /**
         * @var string|null
         */
        private ?string $color = null;

        /**
         * @var string|null
         */
        private ?string $requestUrl = null;

        /**
         * @var string|null
         */
        private ?string $requestMethod = null;

        /**
         * @return Button
         */
        public static function create(): Button
        {
            return new static();
        }

        /**
         * @param string $title
         *
         * @return Button
         */
        public function setTitle(string $title): Button
        {
            $this->title = $title;

            return $this;
        }

        /**
         * @param string $type
         *
         * @return Button
         */
        public function setType(string $type): Button
        {
            $this->type = $type;

            return $this;
        }

        /**
         * @param string $color
         *
         * @return Button
         */
        public function setColor(string $color): Button
        {
            $this->color = $color;

            return $this;
        }

        /**
         * @param string $requestUrl
         *
         * @return Button
         */
        public function setRequestUrl(string $requestUrl): Button
        {
            $this->requestUrl = $requestUrl;

            return $this;
        }

        /**
         * @param string $requestMethod
         *
         * @return Button
         */
        public function setRequestMethod(string $requestMethod): Button
        {
            $this->requestMethod = $requestMethod;

            return $this;
        }

        /**
         * @return array
         */
        public function export(): array
        {
            return [
                'type' => $this->type,
                'title' => $this->title,
                'color' => $this->color,
                'request_url' => $this->requestUrl,
                'request_method' => $this->requestMethod,
            ];
        }
    }
