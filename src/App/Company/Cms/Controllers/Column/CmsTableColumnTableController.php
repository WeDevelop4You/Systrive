<?php

namespace App\Company\Cms\Controllers\Column;

use App\Company\Cms\DataTables\CmsTableColumnTable;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Cms\Seeders\ColumnSeeder;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Client\DataTable\Table;

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
        $items = \is_null($table) ? ColumnSeeder::create() : $table->columns()->sorted()->get();

        return Table::create($this->structure($company, $cms))
            ->withoutQuery($items)
            ->export();
    }
}
