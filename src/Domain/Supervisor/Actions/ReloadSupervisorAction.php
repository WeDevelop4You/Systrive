<?php

namespace Domain\Supervisor\Actions;

use Exception;
use Support\Services\Supervisor;

class ReloadSupervisorAction
{
    /**
     * @return array
     *
     * @throws Exception
     */
    public function __invoke(): array
    {
        return Supervisor::api()->__call('reloadConfig');
    }
}
