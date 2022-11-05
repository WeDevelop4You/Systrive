<?php

namespace App\Admin\Cms\Responses;

use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\RequestAction;
use Support\Response\Components\Popups\Modals\DeleteModal;
use Support\Response\Response;

class CmsDestroyResponse extends AbstractResponse
{
    public function __construct(
        private readonly Company $company,
        private readonly Cms $cms,
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
                DeleteModal::create('company/cms/dataTable')
                    ->addFooterDeleteButton(
                        RequestAction::create()->delete(
                            route('admin.sa.company.cms.destroy', [
                                $this->company->id,
                                $this->cms->id,
                            ])
                        )
                    )
                    ->addFooterCancelButton()
            );
    }
}
