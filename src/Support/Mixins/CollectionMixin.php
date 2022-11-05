<?php

namespace Support\Mixins;

use Closure;
use Illuminate\Support\Collection;

/**
 * @mixin Collection
 */
class CollectionMixin
{
    public function addIf(): Closure
    {
        return function (bool $condition, mixed $item): static {
            if ($condition) {
                $this->add($item);
            }

            return $this;
        };
    }

    public static function json(): Closure
    {
        return function (string $value): static {
            return static::make(json_decode($value, true));
        };
    }
}
