<?php

    namespace Support\Helpers\Response\Popups\Components;

    use Support\Abstracts\Response\AbstractAction;
    use Support\Enums\Vuetify\VuetifyButtonTypes;
    use Support\Enums\Vuetify\VuetifyColors;

    class Button
    {
        /**
         * @var string
         */
        private string $title;

        /**
         * @var VuetifyColors|null
         */
        private VuetifyColors|null $color = null;

        /**
         * @var VuetifyButtonTypes|null
         */
        private VuetifyButtonTypes|null $type = null;

        /**
         * @var AbstractAction|null
         */
        private AbstractAction|null $action = null;

        /**
         * @var bool
         */
        private bool $isListener = false;

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
         * @param VuetifyColors $color
         *
         * @return Button
         */
        public function setColor(VuetifyColors $color = VuetifyColors::PRIMARY): Button
        {
            $this->color = $color;

            return $this;
        }

        /**
         * @param VuetifyButtonTypes $type
         *
         * @return Button
         */
        public function setType(VuetifyButtonTypes $type): Button
        {
            $this->type = $type;

            return $this;
        }

        /**
         * @param AbstractAction $action
         *
         * @return Button
         */
        public function setAction(AbstractAction $action): Button
        {
            $this->action = $action;

            return $this;
        }

        /**
         * @return $this
         */
        public function setListener(): Button
        {
            $this->isListener = true;

            return $this;
        }

        /**
         * @return array
         */
        public function export(): array
        {
            return [
                'title' => $this->title,
                'type' => $this->type?->value,
                'color' => $this->color?->value,
                'hasListener' => $this->isListener,
                'action' => $this->action?->export(),
            ];
        }
    }
