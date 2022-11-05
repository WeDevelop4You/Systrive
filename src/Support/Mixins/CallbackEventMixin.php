<?php

namespace Support\Mixins;

use Closure;
use Illuminate\Console\Scheduling\CallbackEvent;

/**
 * @mixin CallbackEvent
 */
class CallbackEventMixin
{
    /**
     * @return Closure
     */
    public function withChain(): Closure
    {
        return function (callable $callback): static {
            $this->after($callback);

            return $this;
        };
    }
}
