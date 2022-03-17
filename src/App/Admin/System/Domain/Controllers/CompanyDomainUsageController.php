<?php

    namespace App\Admin\System\Domain\Controllers;

    use App\Admin\System\Domain\ChartData\DomainChart;
    use Domain\Company\Models\Company;
    use Domain\System\Models\System;
    use Domain\System\Models\SystemDomain;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;

    class CompanyDomainUsageController
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
                ->addData(DomainChart::create($domain))
                ->toJson();
        }
    }
