<?php

namespace Support\Mixins;

use Closure;
use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Support\Facades\Cache;

/**
 * @mixin CallbackEvent
 */
class CallbackEventMixin
{
    /**
     * @return Closure
     */
    public function cleanUp(): Closure
    {
        return function (): static {
            $this->before(function () {
                Cache::forget(ScheduleMixin::CACHE_SCHEDULE_RECORD_ID);
            });

            return $this;
        };
    }

    /**
     * @return Closure
     */
    public function withChain(): Closure
    {
        return function (callable $callback): static {
            $this->after($callback)
                ->after(function () {
                    Cache::forget(ScheduleMixin::CACHE_SCHEDULE_RECORD_ID);
                });

            return $this;
        };
    }
}
