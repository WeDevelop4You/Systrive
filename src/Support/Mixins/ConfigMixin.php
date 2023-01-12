<?php

namespace Support\Mixins;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

/**
 * @mixin Config
 */
class ConfigMixin
{
    /**
     * @return Closure
     */
    public function collect(): Closure
    {
        /**
         * @param string $key
         *
         * @return Collection
         */
        return function (string $key): Collection {
            return Collection::make($this->get($key, []));
        };
    }
}
