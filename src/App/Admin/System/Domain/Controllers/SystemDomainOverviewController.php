<?php

    namespace App\Admin\System\Domain\Controllers;

    use App\Admin\System\Domain\Responses\SystemDomainOverviewResponse;
    use Domain\Company\Models\Company;
    use Domain\System\Models\System;
    use Domain\System\Models\SystemDomain;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Collection;
    use Support\Enums\VestaCommands;
    use Support\Services\Vesta;

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
            $configData = Vesta::api()
                ->get(VestaCommands::GET_USER_DOMAIN, $system->username, $domain->name)
                ->first();

            return SystemDomainOverviewResponse::create($company, $domain, Collection::make($configData))->toJson();
        }
    }
