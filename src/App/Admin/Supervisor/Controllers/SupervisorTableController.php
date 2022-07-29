<?php

namespace App\Admin\Supervisor\Controllers;

use App\Admin\Supervisor\DataTables\SupervisorTable;
use Domain\Supervisor\Models\Supervisor;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\AbstractTable;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Helpers\DataTable\Build\DataTable;

class SupervisorTableController extends AbstractTableController
{
    /**
     * @inheritDoc
     */
    protected function getDataTable(): AbstractTable
    {
        return SupervisorTable::create();
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return DataTable::create($this->getDataTable())
            ->withoutQuery(Supervisor::all())
            ->export();
    }
}
