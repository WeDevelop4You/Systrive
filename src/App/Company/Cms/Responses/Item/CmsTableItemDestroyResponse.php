<?php

namespace App\Company\Cms\Responses\Item;

use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RequestAction;
use Support\Client\Components\Popups\Modals\DeleteModal;
use Support\Client\Response;

class CmsTableItemDestroyResponse extends AbstractResponse
{
    /**
     * CmsTableItemEditResponse constructor.
     *
     * @param Company  $company
     * @param Cms      $cms
     * @param CmsTable $table
     * @param CmsModel $model
     */
    public function __construct(
        private readonly Company $company,
        private readonly Cms $cms,
        private readonly CmsTable $table,
        private readonly CmsModel $model
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
                DeleteModal::create('cms/table/items/dataTable')
                    ->addFooterDeleteButton(
                        RequestAction::create()->delete(
                            route('company.cms.table.item.delete', [
                                $this->company->id,
                                $this->cms->id,
                                $this->table->id,
                                $this->model->id,
                            ])
                        )
                    )
                    ->addFooterCancelButton()
            );
    }
}
