<?php

namespace App\Admin\Cms\Responses;

use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RequestAction;
use Support\Client\Components\Popups\Modals\DeleteModal;
use Support\Client\Response;

class CmsDestroyResponse extends AbstractResponse
{
    public function __construct(
        private readonly Company $company,
        private readonly Cms $cms,
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
                DeleteModal::create('company/cms/dataTable')
                    ->addFooterDeleteButton(
                        RequestAction::create()->delete(
                            route('admin.company.cms.destroy', [
                                $this->company->id,
                                $this->cms->id,
                            ])
                        )
                    )
                    ->addFooterCancelButton()
            );
    }
}
