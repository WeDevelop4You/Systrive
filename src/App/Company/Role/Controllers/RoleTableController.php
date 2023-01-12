<?php

    namespace App\Company\Role\Controllers;

    use App\Company\Role\DataTable\RoleTable;
    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Abstracts\Controllers\AbstractTableController;
    use Support\Client\DataTable\Table;

    class RoleTableController extends AbstractTableController
    {
        protected string $dataTable = RoleTable::class;

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
                ->query($company->roles()->withCount('permissions'))
                ->export();
        }
    }
