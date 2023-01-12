<?php

namespace Support\Traits;

use Domain\Monitor\Models\Job;

trait ModelBroadcastRateLimit
{
    final protected function isRateLimit(): bool
    {
        $rateLimit = property_exists($this, 'rateLimit')
            ? $this->rateLimit
            : $this->rateLimit();

        $displayName = get_class($this->newBroadcastableEvent('rateLimit'));

        return $rateLimit < Job::whereJsonContains('payload->displayName', $displayName)->count();
    }

    protected function rateLimit(): int
    {
        return 10;
    }
}
