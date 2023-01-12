<?php

namespace Support\Mixins;

use Closure;
use Illuminate\Support\Collection;

/**
 * @mixin Collection
 */
class CollectionMixin
{
    /**
     * @return Closure
     */
    public function addIf(): Closure
    {
        return function (bool $condition, mixed $item): static {
            if ($condition) {
                $this->add($item);
            }

            return $this;
        };
    }

    /**
     * @return Closure
     */
    public static function json(): Closure
    {
        /**
         * @param string $value
         *
         * @return $this
         */
        return function (string $value): static {
            return self::make(json_decode($value, true));
        };
    }

    /**
     * @return Closure
     */
    public static function eachCollect(): Closure
    {
        /**
         * @param callable $callable
         *
         * @return void
         */
        return function (callable $callable): void {
            $this->each(function (array $items, string $key) use ($callable) {
                return $callable(self::make($items), $key);
            });
        };
    }

    /**
     * @return Closure
     */
    public static function getCollect(): Closure
    {
        /**
         * @param string              $key
         * @param Closure|string|null $default
         *
         * @return $this
         */
        return function (string $key, Closure|string $default = null): static {
            return self::make($this->get($key, $default));
        };
    }
}
