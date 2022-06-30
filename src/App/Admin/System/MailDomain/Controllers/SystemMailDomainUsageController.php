<?php

    namespace App\Admin\System\MailDomain\Controllers;

    use App\Admin\System\MailDomain\ChartData\SystemMailDomainChart;
    use Domain\Company\Models\Company;
    use Domain\System\Models\System;
    use Domain\System\Models\SystemMailDomain;
    use Illuminate\Http\JsonResponse;
    use Support\Response\Response;

    class SystemMailDomainUsageController
    {
        /**
         * @param Company          $company
         * @param System           $system
         * @param SystemMailDomain $mailDomain
         *
         * @return JsonResponse
         */
        public function index(Company $company, System $system, SystemMailDomain $mailDomain): JsonResponse
        {
            return Response::create()
                ->addData(SystemMailDomainChart::create($mailDomain))
                ->toJson();
        }
    }
