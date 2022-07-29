<?php

namespace App\Admin\Job\Controller;

use App\Admin\Job\DataTables\JobProcessesTable;
use Domain\Job\Mappings\JobOperationTableMap;
use Domain\Job\Models\JobOperation;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\AbstractTable;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Helpers\DataTable\Build\DataTable;

class JobProcessTableController extends AbstractTableController
{
    /**
     * @inheritDoc
     */
    protected function getDataTable(): AbstractTable
    {
        return JobProcessesTable::create();
    }

    /**
     * @param JobOperation|null $schedule
     *
     * @return JsonResponse
     */
    public function index(?JobOperation $schedule = null): JsonResponse
    {
        if ($schedule instanceof JobOperation) {
            $items = $schedule->children();
        } else {
            $items = JobOperation::whereNull(JobOperationTableMap::SCHEDULE_TYPE);
        }

        return DataTable::create($this->getDataTable())
            ->query($items)
            ->export();
    }
}
