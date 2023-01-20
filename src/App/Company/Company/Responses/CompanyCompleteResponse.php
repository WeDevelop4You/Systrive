<?php

namespace App\Company\Company\Responses;

use App\Company\Company\Forms\CompanyForm;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;
use Support\Enums\SessionKeyType;

class CompanyCompleteResponse extends AbstractResponse
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
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addPopup(
                FormModal::create('form')
                    ->setPersistent()
                    ->setTitle(trans('word.complete.company'))
                    ->setForm(CompanyForm::create())
                    ->addFooterCancelButton(
                        RequestAction::create()
                            ->delete(route('misc.session.delete', [
                                'key' => SessionKeyType::KEEP->value,
                            ])),
                    )->addFooterSaveButton(
                        VuexAction::create()
                            ->dispatch(
                                'update',
                                route('company.complete', [
                                    $this->company->id,
                                    $this->token,
                                ])
                            ),
                    )
            );
    }
}
