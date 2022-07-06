<?php

namespace Support\Abstracts;

use Support\Response\Components\Forms\AbstractFormComponent;

abstract class AbstractForm
{
    /**
     * @param ...$arguments
     *
     * @return AbstractFormComponent
     */
    public static function create(...$arguments): AbstractFormComponent
    {
        $instance = new static(...$arguments);

        return $instance->handle();
    }

    /**
     * @return AbstractFormComponent
     */
    abstract protected function handle(): AbstractFormComponent;
}
