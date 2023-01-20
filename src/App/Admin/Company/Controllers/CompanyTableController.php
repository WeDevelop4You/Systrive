<?php

namespace App\Admin\Company\Controllers;

use App\Admin\Company\DataTables\CompanyTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Client\DataTable\Table;

class CompanyTableController extends AbstractTableController
{
    protected string $dataTable = CompanyTable::class;

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
            ->query(Company::withTrashed()->with('owner'))
            ->export();
    }
}
