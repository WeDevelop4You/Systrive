<?php

namespace App\Admin\Company\Responses;

use App\Admin\Company\Resources\CompanyEditResource;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\Form\FormType;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Forms\CustomFormComponent;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;

class CompanyEditResponse extends AbstractResponse
{
    /**
     * CompanyCreateResponse constructor.
     *
     * @param Company $company
     */
    protected function __construct(
        private readonly Company $company,
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addData(CompanyEditResource::make($this->company))
            ->addPopup(
                FormModal::create('companies/form')
                    ->setPersistent()
                    ->setTitle(trans('word.edit.edit'))
                    ->setForm(
                        CustomFormComponent::create()
                            ->setType(FormType::COMPANY)
                    )
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()
                            ->dispatch(
                                'companies/update',
                                route('admin.admin.company.edit', [
                                    $this->company->id,
                                ])
                            ),
                    )
            );
    }
}
