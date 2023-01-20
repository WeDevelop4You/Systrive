<?php

namespace App\Company\Role\Responses;

use Domain\Company\Models\Company;
use Domain\Role\Models\Role;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RequestAction;
use Support\Client\Components\Popups\Modals\DeleteModal;
use Support\Client\Response;
use Support\Utils\VuexNamespace;

class RoleDestroyResponse extends AbstractResponse
{
    /**
     * CompanyRoleDestroyResponse constructor.
     *
     * @param Company $company
     * @param Role    $role
     */
    public function __construct(
        private readonly Company $company,
        private readonly Role $role
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addPopup(
                DeleteModal::create(VuexNamespace::createCompanyWhenAdmin('roles/dataTable'))
                    ->addFooterDeleteButton(
                        RequestAction::create()
                            ->delete(route('company.role.destroy', [
                                $this->company->id,
                                $this->role->id,
                            ]))
                    )
                    ->addFooterCancelButton()
            );
    }
}
