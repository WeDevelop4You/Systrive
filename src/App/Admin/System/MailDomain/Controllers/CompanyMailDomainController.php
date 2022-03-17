<?php

    namespace App\Admin\System\MailDomain\Controllers;

    use App\Admin\System\MailDomain\ListDetails\MailDomainListDetail;
    use App\Admin\System\MailDomain\Resources\CompanyMailDomainResource;
    use Domain\Company\Models\Company;
    use Domain\System\Models\System;
    use Domain\System\Models\SystemMailDomain;
    use Illuminate\Http\JsonResponse;
    use Support\Enums\VestaCommands;
    use Support\Helpers\Response\Response;
    use Support\Helpers\Vesta\VestaAPIHelper;

    ;

    class CompanyMailDomainController
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
            $configData = VestaAPIHelper::create()
                ->getCommand(VestaCommands::GET_USER_MAIL_DOMAIN, $system->username, $mailDomain->name)
                ->first();

            $mailDomain->listDetails = MailDomainListDetail::create($configData, $mailDomain);

            return Response::create()
                ->addData(new CompanyMailDomainResource($mailDomain))
                ->toJson();
        }
    }
