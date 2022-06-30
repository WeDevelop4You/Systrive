<?php

namespace Support\Abstracts\Response\Components\ListDetails;

use Illuminate\Support\Collection;
use Support\Helpers\Response\Components\ListDetails\ListDetailsComponent;

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

    abstract protected function handle(): ListDetailsComponent;
}
