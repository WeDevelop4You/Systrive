<?php

namespace Support\Abstracts;

use Support\Client\Components\Forms\FormComponent;

abstract class AbstractForm
{
    /**
     * @param ...$arguments
     *
     * @return FormComponent
     */
    public static function create(...$arguments): FormComponent
    {
        $instance = new static(...$arguments);

        return $instance->handle();
    }

    /**
     * @return FormComponent
     */
    abstract protected function handle(): FormComponent;
}
