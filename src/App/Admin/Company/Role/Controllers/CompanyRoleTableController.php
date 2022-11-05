<?php

    namespace App\Admin\Company\Role\Controllers;

    use App\Admin\Company\Role\DataTable\CompanyRoleTable;
    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Abstracts\Controllers\AbstractTableController;
    use Support\Helpers\DataTable\Build\DataTable;

    class CompanyRoleTableController extends AbstractTableController
    {
        protected string $dataTable = CompanyRoleTable::class;

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
            return DataTable::create($this->structure())
                ->query($company->roles()->withCount('permissions'))
                ->export();
        }
    }
