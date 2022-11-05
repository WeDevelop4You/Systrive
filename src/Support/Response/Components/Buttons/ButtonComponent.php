<?php

    namespace Support\Response\Components\Buttons;

    use Support\Enums\Component\Vuetify\VuetifyButtonType;
    use Support\Enums\Component\Vuetify\VuetifyColor;
    use Support\Response\Components\Icons\TextIconComponent;
    use Support\Response\Components\Utils\ThemeComponent;

    class ButtonComponent extends AbstractButtonComponent
    {
        /**
         * @inheritDoc
         */
        protected function getComponentName(): string
        {
            return 'BtnComponent';
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
         * @param VuetifyColor|ThemeComponent $color
         *
         * @return ButtonComponent
         */
        public function setColor(VuetifyColor|ThemeComponent $color = VuetifyColor::PRIMARY): ButtonComponent
        {
            $value = $color instanceof ThemeComponent
                ? $color->export()
                : $color->value;

            return $this->setAttribute('color', $value);
        }

        /**
         * @param VuetifyButtonType $type
         *
         * @return ButtonComponent
         */
        public function setType(VuetifyButtonType $type = VuetifyButtonType::TEXT): ButtonComponent
        {
            return $this->setAttribute($type->value, true);
        }
    }
