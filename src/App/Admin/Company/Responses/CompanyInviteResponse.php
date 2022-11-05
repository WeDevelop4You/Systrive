<?php

namespace App\Admin\Company\Responses;

use App\Admin\Company\Resources\CompanyCreateResource;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\Form\FormType;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Forms\CustomFormComponent;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;

class CompanyInviteResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addData(CompanyCreateResource::make(new Company()))
            ->addPopup(
                FormModal::create('companies/form')
                    ->setPersistent()
                    ->setTitle(trans('word.invite.invite'))
                    ->setForm(
                        CustomFormComponent::create()
                            ->setType(FormType::COMPANY)
                    )
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()
                            ->dispatch('companies/store', route(
                                'admin.admin.company.invite'
                            )),
                    )
            );
    }
}
