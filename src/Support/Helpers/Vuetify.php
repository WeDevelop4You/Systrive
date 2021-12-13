<?php

    namespace Support\Helpers;

    class Vuetify
    {
        public const COLOR_PRIMARY = 'primary';
        public const COLOR_SECONDARY = 'secondary';
        public const COLOR_ACCENT = 'accent';
        public const COLOR_ERROR = 'error';
        public const COLOR_INFO = 'info';
        public const COLOR_SUCCESS = 'success';
        public const COLOR_WARNING = 'warning';

        /**
         * @param string $translation
         *
         * @return string
         */
        public static function translateToVuetify(string $translation): string
        {
            return sprintf('$vuetify.%s', $translation);
        }
    }
