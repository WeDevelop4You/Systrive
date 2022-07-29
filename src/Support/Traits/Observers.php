<?php

namespace Support\Traits;

trait Observers
{
    /**
     * @return array
     */
    public static function getObservers(): array
    {
        $instance = new static();

        return $instance->observers ?? [];
    }
}
