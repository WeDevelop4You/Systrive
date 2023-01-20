<?php

namespace App\Company\User\Controllers;

use App\Company\User\DataTable\UserTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Abstracts\Controllers\AbstractTableController;
use Support\Client\DataTable\Table;

class UserTableController extends AbstractTableController
{
    protected string $dataTable = UserTable::class;

    /**
     * @param Company $company
     *
     * @return JsonResponse
     */
    public function index(Company $company): JsonResponse
    {
        return $this->headers();
    }

    /**
     * @param Company $company
     *
     * @return JsonResponse
     */
    public function action(Company $company): JsonResponse
    {
        return Table::create($this->structure())
            ->query($company->users()->withTrashed())
            ->export();
    }
}
