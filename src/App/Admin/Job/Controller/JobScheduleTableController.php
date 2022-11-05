<?php

namespace App\Admin\Job\Controller;

use App\Admin\Job\DataTables\JobSchedulesTable;
use Domain\Job\Mappings\JobOperationTableMap;
use Domain\Job\Models\JobOperation;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Helpers\DataTable\Build\DataTable;

class JobScheduleTableController extends AbstractTableController
{
    /**
     * @var string
     */
    protected string $dataTable = JobSchedulesTable::class;

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->headers();
    }

    /**
     * @return JsonResponse
     */
    public function actions(): JsonResponse
    {
        return DataTable::create($this->structure())
            ->query(
                JobOperation::query()
                    ->withCount(JobOperationTableMap::RELATIONSHIP_CHILDREN)
                    ->whereNotNull(JobOperationTableMap::SCHEDULE_TYPE)
            )
            ->export();
    }
}
