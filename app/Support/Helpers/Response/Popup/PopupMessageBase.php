<?php

    namespace Support\Helpers\Response\Popup;

    use Illuminate\Support\Str;

    class PopupMessageBase
    {
        public const INFO_TYPE = 'info';
        public const ERROR_TYPE = 'error';
        public const SUCCESS_TYPE = 'success';
        public const WARNING_TYPE = 'warning';

        /**
         * @var array
         */
        public array $data;

        /**
         * @var string
         */
        protected string $text;

        /**
         * @param string|null $text
         */
        public function __construct(string $text, int $statusCode)
        {
            $this->text = $text;
            $this->setText($text);
            $this->selectedTypeByStatusCode($statusCode);
        }

        /**
         * @return $this
         */
        protected function setText(?string $text = null): PopupMessageBase
        {
            $this->data['text'] = $text ?? $this->text;

            return $this;
        }

        /**
         * @param string $type
         * @return PopupMessageBase
         */
        public function setType(string $type): PopupMessageBase
        {
            $this->data['type'] = $type;

            return $this;
        }

        /**
         * @param string $icon
         * @return PopupMessageBase
         */
        public function setIcon(string $icon): PopupMessageBase
        {
            $this->data['icon'] = $icon;

            return $this;
        }

        /**
         * @param string $color
         * @return PopupMessageBase
         */
        public function setColor(string $color): PopupMessageBase
        {
            $this->data['color'] = $color;

            return $this;
        }

        /**
         * @param ...$links
         * @return PopupMessageBase
         */
        public function insertLinksInChat(...$links): PopupMessageBase
        {
            foreach ($links as $link) {
                $htmlLink = "<a class='text--primary' href='{$link}'>";
                $this->text = Str::of($this->text)
                    ->replaceFirst('[<', $htmlLink)
                    ->replaceFirst('>]', '</a>');
            }

            return $this->setText();
        }

        private function selectedTypeByStatusCode(int $statusCode)
        {
            switch ($statusCode) {
                case 200:
                case 201:
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
