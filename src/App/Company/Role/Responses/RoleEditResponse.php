<?php

namespace App\Company\Role\Responses;

use App\Company\Role\Forms\RoleForm;
use App\Company\Role\Resources\RoleResource;
use Domain\Company\Models\Company;
use Domain\Role\Models\Role;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;
use Support\Utils\VuexNamespace;

class RoleEditResponse extends AbstractResponse
{
    /**
     * CompanyRoleEditResponse constructor.
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
            ->addData(RoleResource::make($this->role))
            ->addPopup(
                FormModal::create(VuexNamespace::createCompanyWhenAdmin('roles/form'))
                    ->setPersistent()
                    ->setTitle(trans('word.edit.edit'))
                    ->setForm(RoleForm::create())
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            VuexNamespace::createCompanyWhenAdmin('roles/update'),
                            route('company.role.edit', [
                                $this->company->id,
                                $this->role->id,
                            ])
                        )
                    )
            );
    }
}
