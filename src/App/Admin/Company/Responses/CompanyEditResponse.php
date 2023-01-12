<?php

namespace App\Admin\Company\Responses;

use App\Admin\Company\Forms\CompanyForm;
use App\Admin\Company\Resources\CompanyResource;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;

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
            ->addData(CompanyResource::make($this->company))
            ->addPopup(
                FormModal::create('companies/form')
                    ->setPersistent()
                    ->setTitle(trans('word.edit.edit'))
                    ->setForm(CompanyForm::create($this->company, true))
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()
                            ->dispatch(
                                'companies/update',
                                route('admin.company.edit', [
                                    $this->company->id,
                                ])
                            ),
                    )
            );
    }
}
