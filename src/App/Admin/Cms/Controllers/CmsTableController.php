<?php

namespace App\Admin\Cms\Controllers;

use App\Admin\Cms\DataTables\CmsTable;
use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Helpers\DataTable\Build\DataTable;

class CmsTableController extends AbstractTableController
{
    protected string $dataTable = CmsTable::class;

    /**
     * @param Company $company
     *
     * @return JsonResponse
     */
    public function index(Company $company): JsonResponse
    {
        return $this->headers($company);
    }

    /**
     * @param Company $company
     *
     * @return JsonResponse
     */
    public function action(Company $company): JsonResponse
    {
        return DataTable::create($this->structure($company))
            ->query(Cms::whereCompanyId($company->id)->withTrashed())
            ->export();
    }
}
