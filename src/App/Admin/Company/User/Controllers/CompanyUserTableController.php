<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\DataTable\CompanyUserTable;
    use App\Admin\Company\User\Resources\CompanyUserDataResource;
    use Domain\Company\Models\Company;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Support\Helpers\Data\Build\DataTable;

    class CompanyUserTableController
    {
        /**
         * @param Company $company
         *
         * @return AnonymousResourceCollection
         */
        public function index(Company $company): AnonymousResourceCollection
        {
            return DataTable::create($company->users()->withTrashed())
                ->setColumns(CompanyUserTable::create())
                ->getData(CompanyUserDataResource::class);
        }
    }
