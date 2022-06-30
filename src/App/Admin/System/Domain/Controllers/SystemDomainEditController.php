<?php

    namespace App\Admin\System\Domain\Controllers;

    use App\Admin\System\Domain\Resources\SystemDomainResource;
    use Domain\Company\Models\Company;
    use Domain\System\Models\System;
    use Domain\System\Models\SystemDomain;
    use Illuminate\Http\JsonResponse;
    use Support\Enums\VestaCommands;
    use Support\Response\Response;
    use Support\Services\Vesta;

    ;

    class SystemDomainEditController
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

            $configData['NAME'] = $domain->name;

            return Response::create()
                ->addData(new SystemDomainResource((object) $configData))
                ->toJson();
        }
    }
