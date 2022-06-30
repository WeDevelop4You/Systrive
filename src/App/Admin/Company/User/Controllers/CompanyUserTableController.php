<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\DataTable\CompanyUserTable;
    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Abstracts\AbstractTable;
    use Support\Abstracts\Controllers\AbstractTableController;
    use Support\Helpers\Data\Build\DataTable;

    class CompanyUserTableController extends AbstractTableController
    {
        protected function getDataTable(): AbstractTable
        {
            return CompanyUserTable::create();
        }

        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function index(Company $company): JsonResponse
        {
            return DataTable::create($this->getDataTable())
                ->query($company->users()->withTrashed())
                ->export();
        }
    }
