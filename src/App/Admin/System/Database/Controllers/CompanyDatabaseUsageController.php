<?php

    namespace App\Admin\System\Database\Controllers;

    use App\Admin\System\Database\ChartData\DatabaseChart;
    use Domain\Company\Models\Company;
    use Domain\System\Models\System;
    use Domain\System\Models\SystemDatabase;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;

    class CompanyDatabaseUsageController
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
                ->addData(DatabaseChart::create($database))
                ->toJson();
        }
    }
