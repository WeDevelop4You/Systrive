<?php

use Spatie\Permission\PermissionRegistrar;

if (! function_exists('instanceofArray')) {
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

if (! function_exists('createRelationshipString')) {
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

if (! function_exists('alias')) {
    /**
     * @param string $alias
     * @param string $column
     *
     * @return string
     */
    function alias(string $alias, string $column): string
    {
        return "{$alias}.{$column}";
    }
}

if (! function_exists('setCompanyId')) {
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

if (! function_exists('createBase64Image')) {
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

if (! function_exists('prep_url')) {
    /**
     * @param string $str
     *
     * @return string
     */
    function prep_url(string $str = ''): string
    {
        if ($str === 'http://' || $str === '') {
            return '';
        }

        $url = parse_url($str);

        if (! $url || ! isset($url['scheme'])) {
            return 'http://'.$str;
        }

        return $str;
    }
}

if (! function_exists('src_path')) {
    function src_path(string $path = ''): string
    {
        $path = 'src'.($path != '' ? DIRECTORY_SEPARATOR.$path : '');

        return app()->basePath($path);
    }
}

if (! function_exists('application_path')) {
    function application_path($path = ''): string
    {
        $path = 'App'.($path != '' ? DIRECTORY_SEPARATOR.$path : '');

        return src_path($path);
    }
}

if (! function_exists('domain_path')) {
    function domain_path($path = ''): string
    {
        $path = 'Domain'.($path != '' ? DIRECTORY_SEPARATOR.$path : '');

        return src_path($path);
    }
}

if (! function_exists('support_path')) {
    function support_path($path = ''): string
    {
        $path = 'Support'.($path != '' ? DIRECTORY_SEPARATOR.$path : '');

        return src_path($path);
    }
}
