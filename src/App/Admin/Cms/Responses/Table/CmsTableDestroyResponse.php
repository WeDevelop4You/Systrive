<?php

namespace App\Admin\Cms\Responses\Table;

use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\RequestAction;
use Support\Response\Components\Popups\Modals\DeleteModal;
use Support\Response\Response;

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
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addPopup(
                DeleteModal::create()
                    ->addFooterDeleteButton(
                        RequestAction::create()->delete(
                            route('admin.company.cms.table.destroy', [
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
