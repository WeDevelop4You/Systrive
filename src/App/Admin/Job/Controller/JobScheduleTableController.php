<?php

namespace App\Admin\Job\Controller;

use App\Admin\Job\DataTables\JobSchedulesTable;
use Domain\Job\Mappings\JobOperationTableMap;
use Domain\Job\Models\JobOperation;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\AbstractTable;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Helpers\DataTable\Build\DataTable;

class JobScheduleTableController extends AbstractTableController
{
    /**
     * @inheritDoc
     */
    protected function getDataTable(): AbstractTable
    {
        return JobSchedulesTable::create();
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return DataTable::create($this->getDataTable())
            ->query(
                JobOperation::query()
                    ->withCount(JobOperationTableMap::RELATIONSHIP_CHILDREN)
                    ->whereNotNull(JobOperationTableMap::SCHEDULE_TYPE)
            )
            ->export();
    }
}
