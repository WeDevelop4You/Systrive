<?php

namespace App\Admin\Company\Role\Responses;

use App\Admin\Company\Role\Resources\CompanyRoleResource;
use Domain\Company\Models\Company;
use Domain\Role\Models\Role;
use Support\Abstracts\AbstractResponse;
use Support\Enums\FormTypes;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Forms\CustomFormComponent;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;

class CompanyRoleEditResponse extends AbstractResponse
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
            ->addData(CompanyRoleResource::make($this->role))
            ->addPopup(
                FormModal::create('company/roles/form')
                    ->setPersistent()
                    ->setTitle(trans('word.edit.edit'))
                    ->setForm(
                        CustomFormComponent::create()
                            ->setType(FormTypes::COMPANY_ROLE)
                    )
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'company/roles/update',
                            route('admin.company.role.edit', [
                                $this->company->id,
                                $this->role->id,
                            ])
                        )
                    )
            );
    }
}
