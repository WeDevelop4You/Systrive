<?php

    namespace App\Admin\Company\Role\Controllers;

    use App\Admin\Company\Role\DataTable\CompanyRoleTable;
    use App\Admin\Company\Role\Resources\CompanyRoleDataResource;
    use Domain\Company\Models\Company;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Support\Helpers\Data\Build\DataTable;

    class CompanyRoleTableController
    {
        /**
         * @param Company $company
         *
         * @return AnonymousResourceCollection
         */
        public function index(Company $company): AnonymousResourceCollection
        {
            return DataTable::create($company->roles()->withCount('permissions'))
                ->setColumns(CompanyRoleTable::create())
                ->getData(CompanyRoleDataResource::class);
        }
    }
