<?php

    namespace Support\Helpers;

    class VuetifyHelper
    {
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
