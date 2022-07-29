<?php

namespace Domain\Supervisor\Actions;

use Exception;
use Support\Services\Supervisor;

class ReloadSupervisorAction
{
    /**
     * @throws Exception
     *
     * @return array
     */
    public function __invoke(): array
    {
        return Supervisor::api()->__call('reloadConfig');
    }
}
