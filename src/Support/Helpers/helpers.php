<?php

    use Support\Helpers\Vuetify;

    if (!function_exists('translateToVuetify')) {
        /**
         * @param string $translation
         *
         * @return string
         */
        function translateToVuetify(string $translation): string
        {
            return Vuetify::translateToVuetify($translation);
        }
    }
