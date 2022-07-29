<?php

namespace App\Admin\Company\Responses;

use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\FormTypes;
use Support\Enums\SessionKeyTypes;
use Support\Response\Actions\RequestAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Forms\CustomFormComponent;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;

class CompanyCreateResponse extends AbstractResponse
{
    /**
     * CompanyCreateResponse constructor.
     *
     * @param Company $company
     * @param string  $token
     */
    protected function __construct(
        private readonly Company $company,
        private readonly string $token,
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
                FormModal::create('company/form')
                    ->setPersistent()
                    ->setTitle(trans('modal.company.complete'))
                    ->setForm(
                        CustomFormComponent::create()
                            ->setType(FormTypes::COMPANY_COMPLETE)
                    )
                    ->addFooterCancelButton(
                        RequestAction::create()
                            ->delete(route('admin.session.delete', [
                                'key' => SessionKeyTypes::KEEP->value,
                            ])),
                    )->addFooterSaveButton(
                        VuexAction::create()
                            ->dispatch(
                                'company/create',
                                route('admin.company.create', [
                                    $this->company->id,
                                    $this->token,
                                ])
                            ),
                    )
            );
    }
}
