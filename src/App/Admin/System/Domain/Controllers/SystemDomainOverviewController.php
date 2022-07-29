<?php

    namespace App\Admin\System\Domain\Controllers;

    use App\Admin\System\Domain\Responses\SystemDomainOverviewResponse;
    use Domain\Company\Models\Company;
    use Domain\System\Models\System;
    use Domain\System\Models\SystemDomain;
    use Illuminate\Http\JsonResponse;

    class SystemDomainOverviewController
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
            return SystemDomainOverviewResponse::create($company, $system, $domain)->toJson();
        }
    }
