<?php

namespace App\Admin\Company\User\Responses;

use App\Admin\Company\User\Resources\CompanyUserCreateResource;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\FormTypes;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Forms\CustomFormComponent;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;

class CompanyUserInviteResponse extends AbstractResponse
{
    public function __construct(
        private readonly company $company
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addData(CompanyUserCreateResource::make(null))
            ->addPopup(
                FormModal::create('company/users/form')
                    ->setPersistent()
                    ->setTitle(trans('word.invite.invite'))
                    ->setForm(
                        CustomFormComponent::create()
                            ->setType(FormTypes::COMPANY_USER)
                    )
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'company/users/store',
                            route('admin.company.user.invite', [
                                $this->company->id,
                            ])
                        )
                    )
            );
    }
}
