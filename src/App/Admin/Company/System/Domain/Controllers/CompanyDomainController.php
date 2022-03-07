<?php

    namespace App\Admin\Company\System\Domain\Controllers;

    use App\Admin\Company\System\Domain\ListDetails\DomainListDetail;
    use App\Admin\Company\System\Domain\Resources\CompanyDomainResource;
    use Domain\Company\Models\Company;
    use Domain\System\Models\System;
    use Domain\System\Models\SystemDomain;
    use Illuminate\Http\JsonResponse;
    use Support\Enums\VestaCommands;
    use Support\Helpers\Response\Response;
    use Support\Helpers\Vesta\VestaAPIHelper;

    ;

    class CompanyDomainController
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
            $configData = VestaAPIHelper::create()
                ->getCommand(VestaCommands::GET_USER_DOMAIN, $system->username, $domain->name)
                ->first();

            $domain->listDetails = DomainListDetail::create($configData, $domain);

            return Response::create()
                ->addData(new CompanyDomainResource($domain))
                ->toJson();
        }
    }
