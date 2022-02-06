<?php

    namespace App\Admin\Company\System\Domain\Controllers;

    use App\Admin\Company\System\Domain\ChartData\DomainChart;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;

    class CompanyDomainUsageController
    {
        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            return Response::create()
                ->addData(DomainChart::create())
                ->toJson();
        }
    }
