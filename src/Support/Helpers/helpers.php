<?php

    use Spatie\Permission\PermissionRegistrar;
    use Support\Helpers\VuetifyHelper;

    if (!function_exists('translateToVuetify')) {
        /**
         * @param string $translation
         *
         * @return string
         */
        function translateToVuetify(string $translation): string
        {
            return VuetifyHelper::translateToVuetify($translation);
        }
    }

    if (!function_exists('setCompanyId')) {
        /**
         * @param int $id
         *
         * @return void
         */
        function setCompanyId(int $id = 0)
        {
            app(PermissionRegistrar::class)->setPermissionsTeamId($id);
        }
    }

    if (!function_exists('createBase64Image')) {
        /**
         * @param string $base64
         *
         * @return string
         */
        function createBase64Image(string $base64): string
        {
            return "data:image/png;base64,{$base64}";
        }
    }

    if (!function_exists('prep_url')) {
        /**
         * @param   string  the URL
         *
         * @return string
         */
        function prep_url($str = '')
        {
            if ($str === 'http://' || $str === '') {
                return '';
            }

            $url = parse_url($str);

            if (!$url || !isset($url['scheme'])) {
                return 'http://'.$str;
            }

            return $str;
        }
    }
