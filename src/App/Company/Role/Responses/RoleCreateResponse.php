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

class RoleCreateResponse extends AbstractResponse
{
    /**
     * CompanyRoleCreateResponse constructor.
     *
     * @param Company $company
     */
    public function __construct(
        private readonly Company $company
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addData(RoleResource::make(new Role()))
            ->addPopup(
                FormModal::create(VuexNamespace::createCompanyWhenAdmin('roles/form'))
                    ->setPersistent()
                    ->setTitle(trans('word.create.create'))
                    ->setForm(RoleForm::create())
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            VuexNamespace::createCompanyWhenAdmin('roles/store'),
                            route('company.role.create', [
                                $this->company->id,
                            ])
                        ),
                    )
            );
    }
}
