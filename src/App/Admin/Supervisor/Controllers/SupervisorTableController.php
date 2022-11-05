<?php

namespace App\Admin\Supervisor\Controllers;

use App\Admin\Supervisor\DataTables\SupervisorTable;
use Domain\Supervisor\Models\Supervisor;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Helpers\DataTable\Build\DataTable;

class SupervisorTableController extends AbstractTableController
{
    protected string $dataTable = SupervisorTable::class;

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
        return DataTable::create($this->structure())
            ->withoutQuery(Supervisor::all())
            ->export();
    }
}
