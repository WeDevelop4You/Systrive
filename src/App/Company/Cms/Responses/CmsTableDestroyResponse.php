<?php

namespace App\Company\Cms\Responses;

use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RequestAction;
use Support\Client\Components\Popups\Modals\DeleteModal;
use Support\Client\Response;

class CmsTableDestroyResponse extends AbstractResponse
{
    public function __construct(
        private readonly Company $company,
        private readonly Cms $cms,
        private readonly CmsTable $table
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
                DeleteModal::create()
                    ->addFooterDeleteButton(
                        RequestAction::create()->delete(
                            route('company.cms.table.destroy', [
                                $this->company->id,
                                $this->cms->id,
                                $this->table->id,
                            ]),
                        )
                    )
                    ->addFooterCancelButton()
            );
    }
}
