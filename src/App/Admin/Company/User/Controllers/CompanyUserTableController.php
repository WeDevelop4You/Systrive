<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\DataTable\CompanyUserTable;
    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Abstracts\Controllers\AbstractTableController;
    use Support\Helpers\DataTable\Build\DataTable;

    class CompanyUserTableController extends AbstractTableController
    {
        protected string $dataTable = CompanyUserTable::class;

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
                ->query($company->users()->withTrashed())
                ->export();
        }
    }
