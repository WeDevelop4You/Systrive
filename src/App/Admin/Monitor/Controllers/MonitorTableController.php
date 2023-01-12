<?php

namespace App\Admin\Monitor\Controllers;

use App\Admin\Monitor\DataTables\MonitorTable;
use Domain\Monitor\Mappings\MonitorTableMap;
use Domain\Monitor\Models\Monitor;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Client\DataTable\Table;

class MonitorTableController extends AbstractTableController
{
    protected string $dataTable = MonitorTable::class;

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
    public function action(): JsonResponse
    {
        return Table::create($this->structure())
            ->query(Monitor::orderByDesc(MonitorTableMap::COL_CREATED_AT))
            ->export();
    }
}
