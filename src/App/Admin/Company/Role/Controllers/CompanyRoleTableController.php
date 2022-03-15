<?php

    namespace App\Admin\Company\Role\Controllers;

    use App\Admin\Company\Role\DataTable\CompanyRoleTable;
    use App\Admin\Company\Role\Resources\CompanyRoleDataResource;
    use Domain\Company\Models\Company;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Support\Abstracts\AbstractTable;
    use Support\Abstracts\AbstractTableController;
    use Support\Helpers\Data\Build\DataTable;

    class CompanyRoleTableController extends AbstractTableController
    {
        protected function getTableStructure(): AbstractTable
        {
            return CompanyRoleTable::create();
        }

        /**
         * @param Company $company
         *
         * @return AnonymousResourceCollection
         */
        public function items(Company $company): AnonymousResourceCollection
        {
            return DataTable::query($company->roles()->withCount('permissions'))
                ->setColumns($this->getTableStructure())
                ->export(CompanyRoleDataResource::class);
        }
    }
