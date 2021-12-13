<?php

    namespace App\Admin\Company\Role\Controllers;

    use App\Admin\Company\Role\Resources\CompanyRoleListResource;
    use Domain\Company\Models\Company;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Spatie\Permission\Models\Role;

    class CompanyRoleListController
    {
        /**
         * @param Company $company
         *
         * @return AnonymousResourceCollection
         */
        public function index(Company $company): AnonymousResourceCollection
        {
            return CompanyRoleListResource::collection($company->roles);
        }
    }
