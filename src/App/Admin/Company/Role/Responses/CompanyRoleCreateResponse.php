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

class CompanyRoleCreateResponse extends AbstractResponse
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
            ->addData(CompanyRoleResource::make(new Role()))
            ->addPopup(
                FormModal::create('company/roles/form')
                    ->setPersistent()
                    ->setTitle(trans('word.create.create'))
                    ->setForm(
                        CustomFormComponent::create()
                            ->setType(FormTypes::COMPANY_ROLE)
                    )
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'company/roles/store',
                            route('admin.company.role.create', [
                                $this->company->id,
                            ])
                        ),
                    )
            );
    }
}
