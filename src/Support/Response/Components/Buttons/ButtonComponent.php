<?php

    namespace Support\Response\Components\Buttons;

    use Support\Enums\Component\Vuetify\VuetifyButtonTypes;
    use Support\Enums\Component\Vuetify\VuetifyColors;
    use Support\Response\Components\Icons\TextIconComponent;

    class ButtonComponent extends AbstractButtonComponent
    {
        /**
         * @inheritDoc
         */
        protected function getComponentName(): string
        {
            return 'Btn';
        }

        /**
         * @param string $title
         *
         * @return ButtonComponent
         */
        public function setTitle(string $title): ButtonComponent
        {
            return $this->setContent('title', $title);
        }

        /**
         * @param TextIconComponent $component
         *
         * @return ButtonComponent
         */
        public function setTitleWithIcon(TextIconComponent $component): ButtonComponent
        {
            return $this->setdata('component', $component->export());
        }

        /**
         * @param VuetifyColors $color
         *
         * @return ButtonComponent
         */
        public function setColor(VuetifyColors $color = VuetifyColors::PRIMARY): ButtonComponent
        {
            return $this->setAttribute('color', $color->value);
        }

        /**
         * @param VuetifyButtonTypes $type
         *
         * @return ButtonComponent
         */
        public function setType(VuetifyButtonTypes $type = VuetifyButtonTypes::TEXT): ButtonComponent
        {
            return $this->setAttribute($type->value, true);
        }
    }
