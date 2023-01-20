<?php

namespace App\Admin\Company\Responses;

use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RequestAction;
use Support\Client\Components\Popups\Modals\DeleteModal;
use Support\Client\Response;

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
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addPopup(
                DeleteModal::create('companies/dataTable', ! \is_null($this->company->deleted_at))
                    ->addFooterForceDeleteButton(
                        RequestAction::create()->delete(
                            route('admin.company.destroy.force', [
                                $this->company->id,
                            ])
                        )
                    )
                    ->addFooterDeleteButton(
                        RequestAction::create()->delete(
                            route('admin.company.destroy', [
                                $this->company->id,
                            ])
                        ),
                    )
                    ->addFooterCancelButton()
            );
    }
}
