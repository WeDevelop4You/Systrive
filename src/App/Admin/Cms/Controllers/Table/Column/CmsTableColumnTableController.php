<?php

namespace App\Admin\Cms\Controllers\Table\Column;

use App\Admin\Cms\DataTables\CmsTableColumnTable;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Cms\Seeders\ColumnSeeder;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Helpers\DataTable\Build\DataTable;

class CmsTableColumnTableController extends AbstractTableController
{
    protected string $dataTable = CmsTableColumnTable::class;

    /**
     * @param Company       $company
     * @param Cms           $cms
     * @param CmsTable|null $table
     *
     * @return JsonResponse
     */
    public function index(Company $company, Cms $cms, ?CmsTable $table = null): JsonResponse
    {
        return $this->headers($company, $cms);
    }

    /**
     * @param Company       $company
     * @param Cms           $cms
     * @param CmsTable|null $table
     *
     * @return JsonResponse
     */
    public function action(Company $company, Cms $cms, ?CmsTable $table = null): JsonResponse
    {
        if (\is_null($table)) {
            $items = ColumnSeeder::create();
        } else {
            $items = $table->columns()
                ->orderBy(CmsColumnTableMap::AFTER)
                ->get();
        }

        return DataTable::create($this->structure($company, $cms))
            ->withoutQuery($items)
            ->export();
    }
}
