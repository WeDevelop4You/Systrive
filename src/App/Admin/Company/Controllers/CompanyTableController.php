<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\DataTables\CompanyTable;
    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Abstracts\AbstractTable;
    use Support\Abstracts\Controllers\AbstractTableController;
    use Support\Helpers\Data\Build\DataTable;

    class CompanyTableController extends AbstractTableController
    {
        protected function getDataTable(): AbstractTable
        {
            return CompanyTable::create();
        }

        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            return DataTable::create($this->getDataTable())
                ->query(Company::query()->with('owner'))
                ->export();
        }
    }
