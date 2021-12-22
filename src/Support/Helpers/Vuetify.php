<?php

    namespace Support\Helpers;

    class Vuetify
    {
        public const PRIMARY_COLOR = 'primary';
        public const SECONDARY_COLOR = 'secondary';
        public const ACCENT_COLOR = 'accent';
        public const ERROR_COLOR = 'error';
        public const INFO_COLOR = 'info';
        public const SUCCESS_COLOR = 'success';
        public const WARNING_COLOR = 'warning';

        public const GET_METHOD = 'GET';
        public const PATCH_METHOD = 'PATCH';

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
