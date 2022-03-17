<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\DataTables\CompanyTable;
    use App\Admin\Company\Resources\CompanyDataResource;
    use Domain\Company\Models\Company;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Support\Abstracts\AbstractTable;
    use Support\Abstracts\AbstractTableController;
    use Support\Helpers\Data\Build\DataTable;

    class CompanyTableController extends AbstractTableController
    {
        protected function getTableStructure(): AbstractTable
        {
            return CompanyTable::create();
        }

        /**
         * @return AnonymousResourceCollection
         */
        public function index(): AnonymousResourceCollection
        {
            return DataTable::query(Company::query())
                ->setColumns($this->getTableStructure())
                ->export(CompanyDataResource::class);
        }
    }
