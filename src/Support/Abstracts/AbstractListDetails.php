<?php

namespace Support\Abstracts;

use Illuminate\Support\Collection;
use Support\Helpers\Details\ListDetailsHelper;

abstract class AbstractListDetails
{
    protected mixed $data;

    /**
     * @param mixed $data
     * @param       ...$attribute
     *
     * @return array
     */
    public static function create(mixed $data, ...$attribute): array
    {
        $instance = new static(...$attribute);

        $instance->data = is_array($data)
            ? Collection::make($data)
            : $data;

        return $instance->handle()->export();
    }

    abstract protected function handle(): ListDetailsHelper;
}
