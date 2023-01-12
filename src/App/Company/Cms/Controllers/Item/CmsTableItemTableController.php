<?php

namespace App\Company\Cms\Controllers\Item;

use App\Company\Cms\DataTables\CmsTableItemTable;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Client\DataTable\Table;

class CmsTableItemTableController extends AbstractTableController
{
    protected string $dataTable = CmsTableItemTable::class;

    /**
     * @param Company  $company
     * @param Cms      $cms
     * @param CmsTable $table
     *
     * @return JsonResponse
     */
    public function index(Company $company, Cms $cms, CmsTable $table): JsonResponse
    {
        return $this->headers($company, $cms, $table);
    }

    /**
     * @param Company  $company
     * @param Cms      $cms
     * @param CmsTable $table
     *
     * @return JsonResponse
     */
    public function action(Company $company, Cms $cms, CmsTable $table): JsonResponse
    {
        return Table::create($this->structure($company, $cms, $table))
            ->query(CmsModel::query())
            ->export();
    }
}
