<?php

    namespace Support\Enums\Component\Vuetify;

    use Support\Response\Components\Utils\ThemeComponent;

    enum VuetifyColor: string
    {
        case PRIMARY = 'primary';
        case SECONDARY = 'secondary';
        case ACCENT = 'accent';
        case ERROR = 'error';
        case INFO = 'info';
        case SUCCESS = 'success';
        case WARNING = 'warning';
        case TRANSPARENT = 'transparent';
        case NONE = 'undefined';

        case DARK_BACKGROUND = '#121212';
        case DARK_HEADER = '#272727';

        case LIGHT_HEADER = '#f5f5f5';
        case LIGHT_GRAY = '#777777';

        /**
         * @param VuetifyColor $dark
         * @param VuetifyColor $light
         *
         * @return ThemeComponent
         */
        public static function theme(self $dark, self $light): ThemeComponent
        {
            return new ThemeComponent($dark, $light);
        }
    }
