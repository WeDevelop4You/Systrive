<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\DataTable\CompanyTable;
    use App\Admin\Company\Resources\CompanyDataResource;
    use Domain\Company\Models\Company;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Support\Helpers\Data\Build\DataTable;

    class CompanyTableController
    {
        /**
         * @return AnonymousResourceCollection
         */
        public function index(): AnonymousResourceCollection
        {
            return DataTable::create(Company::query())
                ->setColumns(CompanyTable::create())
                ->getData(CompanyDataResource::class);
        }
    }
