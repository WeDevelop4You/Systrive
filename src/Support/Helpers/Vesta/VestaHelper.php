<?php

namespace Support\Helpers\Vesta;

class VestaHelper
{
    /**
     * @param string $value
     * @param bool   $reversed
     *
     * @return array
     */
    public static function isActive(string $value, bool $reversed = false): array
    {
        $activeValues = $reversed
            ? ['no', 'disabled']
            : ['yes', 'enabled'];

        if (!empty($value) && in_array($value, $activeValues)) {
            return [
                'is_active' => true,
                'content' => trans('word.active.active'),
            ];
        }

        return [
            'is_active' => false,
            'content' => trans('word.inactive.inactive'),
        ];
    }
}
