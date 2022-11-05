<?php

namespace App\Admin\Cms\Responses\Table\Item;

use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Response\Components\Overviews\Tables\ServerTableComponent;
use Support\Response\Components\Popups\Modals\ShowModal;
use Support\Response\Response;

class CmsTableItemHistoryResponse extends AbstractResponse
{
    /**
     * CmsTableItemHistoryResponse constructor.
     *
     * @param Company  $company
     * @param Cms      $cms
     * @param CmsTable $table
     */
    public function __construct(
        private readonly Company $company,
        private readonly Cms $cms,
        private readonly CmsTable $table,
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
                ShowModal::create()
                    ->setWidth(1300)
                    ->setTitle(trans('word.history.history'))
                    ->addComponent(
                        ServerTableComponent::create()
                            ->setFlat()
                            ->setSearchable()
                            ->setVuexNamespace('company/cms/table/items/dataTable')
                            ->setHeaderUrl(route('admin.company.cms.table.item.table.headers', [
                                $this->company->id,
                                $this->cms->id,
                                $this->table->id,
                            ]))
                            ->setItemsUrl(route('admin.company.cms.table.item.table.items', [
                                $this->company->id,
                                $this->cms->id,
                                $this->table->id,
                            ]))
                    )
            );
    }
}
