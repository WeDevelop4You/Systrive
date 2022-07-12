<?php

use Spatie\Permission\PermissionRegistrar;

if (!function_exists('instanceofArray')) {
    /**
     * @param       $needed
     * @param array $classes
     *
     * @return bool
     */
    function instanceofArray($needed, array $classes): bool
    {
        foreach ($classes as $class) {
            if ($needed instanceof $class) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('createRelationshipString')) {
    /**
     * @param mixed ...$relationships
     *
     * @return string
     */
    function createRelationshipString(...$relationships): string
    {
        return implode('.', $relationships);
    }
}

if (!function_exists('setCompanyId')) {
    /**
     * @param int $id
     *
     * @return void
     */
    function setCompanyId(int $id = 0): void
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
    function prep_url($str = ''): string
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
