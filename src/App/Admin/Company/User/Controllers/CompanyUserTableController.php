<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\DataTable\CompanyUserTable;
    use App\Admin\Company\User\Resources\CompanyUserDataResource;
    use Domain\Company\Models\Company;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Support\Abstracts\AbstractTable;
    use Support\Abstracts\AbstractTableController;
    use Support\Helpers\Data\Build\DataTable;

    class CompanyUserTableController extends AbstractTableController
    {
        protected function getTableStructure(): AbstractTable
        {
            return CompanyUserTable::create();
        }

        /**
         * @param Company $company
         *
         * @return AnonymousResourceCollection
         */
        public function items(Company $company): AnonymousResourceCollection
        {
            return DataTable::query($company->users()->withTrashed())
                ->setColumns($this->getTableStructure())
                ->export(CompanyUserDataResource::class);
        }
    }
