<?php

    namespace App\Admin\Company\System\Domain\Controllers;

    use App\Admin\Company\System\Domain\Resources\CompanyDomainResource;
    use Domain\Company\Models\Company;
    use Domain\System\Models\System;
    use Domain\System\Models\SystemDomain;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;

    class CompanyDomainShowController
    {
        /**
         * @param Company      $company
         * @param System       $system
         * @param SystemDomain $domain
         *
         * @return JsonResponse
         */
        public function index(Company $company, System $system, SystemDomain $domain): JsonResponse
        {
            return Response::create()
                ->addData(new CompanyDomainResource($domain))
                ->toJson();
        }
    }
