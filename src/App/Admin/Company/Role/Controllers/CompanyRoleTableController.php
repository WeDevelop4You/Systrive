<?php

    namespace App\Admin\Company\Role\Controllers;

    use App\Admin\Company\Role\DataTable\CompanyRoleTable;
    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Abstracts\AbstractTable;
    use Support\Abstracts\Controllers\AbstractTableController;
    use Support\Helpers\Data\Build\DataTable;

    class CompanyRoleTableController extends AbstractTableController
    {
        protected function getDataTable(): AbstractTable
        {
            return CompanyRoleTable::create();
        }

        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function index(Company $company): JsonResponse
        {
            return DataTable::create($this->getDataTable())
                ->query($company->roles()->withCount('permissions'))
                ->export();
        }
    }
