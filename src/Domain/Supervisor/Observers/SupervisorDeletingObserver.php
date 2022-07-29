<?php

namespace Domain\Supervisor\Observers;

use Domain\Supervisor\Models\Supervisor;
use Support\Services\Supervisor as SupervisorService;

class SupervisorDeletingObserver
{
    /**
     * @param Supervisor $supervisor
     *
     * @return bool
     */
    public function deleting(Supervisor $supervisor): bool
    {
        return SupervisorService::file()->delete($supervisor->filename);
    }
}
