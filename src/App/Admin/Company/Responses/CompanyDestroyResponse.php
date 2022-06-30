<?php

namespace App\Admin\Company\Responses;

use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\RequestAction;
use Support\Response\Components\Popups\Modals\DeleteModal;
use Support\Response\Response;

class CompanyDestroyResponse extends AbstractResponse
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
            ->addPopup(
                DeleteModal::create('companies')
                    ->addFooterDeleteButton(
                        RequestAction::create()
                            ->delete(
                                route('admin.admin.company.destroy', [
                                    $this->company->id,
                                ])
                            )
                    )
                    ->addFooterCancelButton()
            );
    }
}
