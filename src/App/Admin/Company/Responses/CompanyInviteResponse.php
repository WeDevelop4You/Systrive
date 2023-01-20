<?php

namespace App\Admin\Company\Responses;

use App\Admin\Company\Forms\CompanyForm;
use App\Admin\Company\Resources\CompanyResource;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;

class CompanyInviteResponse extends AbstractResponse
{
    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        $company = new Company();

        return Response::create()
            ->addData(CompanyResource::make($company))
            ->addPopup(
                FormModal::create('companies/form')
                    ->setPersistent()
                    ->setTitle(trans('word.invite.invite'))
                    ->setForm(CompanyForm::create($company))
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()
                            ->dispatch('companies/store', route(
                                'admin.company.invite'
                            )),
                    )
            );
    }
}
