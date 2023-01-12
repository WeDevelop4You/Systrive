<?php

namespace Support\Traits;

/**
 * @property array $observers
 */
trait Observers
{
    public static function bootObservers(): void
    {
        static::observe(static::$observers ?? []);
    }
}
