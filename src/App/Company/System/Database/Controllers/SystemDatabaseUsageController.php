<?php

    namespace App\Company\System\Database\Controllers;

    use App\Company\System\Database\ChartData\SystemDatabaseChart;
    use Domain\Company\Models\Company;
    use Domain\System\Models\System;
    use Domain\System\Models\SystemDatabase;
    use Illuminate\Http\JsonResponse;
    use Support\Client\Response;

    class SystemDatabaseUsageController
    {
        /**
         * @param Company        $company
         * @param System         $system
         * @param SystemDatabase $database
         *
         * @return JsonResponse
         */
        public function index(Company $company, System $system, SystemDatabase $database): JsonResponse
        {
            return Response::create()
                ->addData(SystemDatabaseChart::create($database))
                ->toJson();
        }
    }
