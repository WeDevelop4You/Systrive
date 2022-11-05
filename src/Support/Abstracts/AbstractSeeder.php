<?php

namespace Support\Abstracts;

use Illuminate\Support\Collection;

abstract class AbstractSeeder
{
    /**
     * @return Collection
     */
    public static function create(): Collection
    {
        $instance = new static();

        return $instance->handler();
    }

    /**
     * @return Collection
     */
    abstract protected function handler(): Collection;
}
