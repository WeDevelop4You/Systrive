<?php

namespace Support\Client\Traits;

use Illuminate\Support\Arr;

trait ComponentWithClasses
{
    /**
     * @param array|string $class
     *
     * @return static
     */
    public function setClass(string|array $class): static
    {
        return $this->setAttribute('class', [
            ...Arr::wrap($class),
            ...$this->getAttribute('class', []),
        ]);
    }
}
