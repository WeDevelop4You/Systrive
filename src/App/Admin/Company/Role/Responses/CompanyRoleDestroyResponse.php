<?php

namespace App\Admin\Company\Role\Responses;

use Domain\Company\Models\Company;
use Domain\Role\Models\Role;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\RequestAction;
use Support\Response\Components\Popups\Modals\DeleteModal;
use Support\Response\Response;

class CompanyRoleDestroyResponse extends AbstractResponse
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
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addPopup(
                DeleteModal::create('company/roles')
                    ->addFooterDeleteButton(
                        RequestAction::create()
                            ->delete(
                                route('admin.company.role.destroy', [
                                    $this->company->id,
                                    $this->role->id,
                                ])
                            )
                    )
                    ->addFooterCancelButton()
            );
    }
}
