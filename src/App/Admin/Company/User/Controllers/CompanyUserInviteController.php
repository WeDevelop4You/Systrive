<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\Requests\CompanyUserInviteRequest;
    use Domain\Company\Actions\InviteUserToCompanyAction;
    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;

    class CompanyUserInviteController
    {
        public function action(CompanyUserInviteRequest $request, Company $company)
        {
            $data = new CompanyUserData(...$request->validated());

            (new InviteUserToCompanyAction($company))($data);
        }
    }
