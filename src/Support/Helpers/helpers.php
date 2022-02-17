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
        function setCompanyId(int $id = 0)
        {
            app(PermissionRegistrar::class)->setPermissionsTeamId($id);
        }
    }

    if (!function_exists('createBase64Image')) {
        function createBase64Image(string $base64): string
        {
            return "data:image/png;base64,{$base64}";
        }
    }
