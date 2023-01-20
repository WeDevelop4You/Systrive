<?php

namespace App\Company\Cms\Responses\Item;

use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Components\Overviews\Tables\LocaleTableComponent;
use Support\Client\Components\Overviews\Tables\ServerTableComponent;
use Support\Client\Components\Popups\Modals\ShowModal;
use Support\Client\Response;

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
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addPopup(
                ShowModal::create()
                    ->setWidth(1300)
                    ->setTitle(trans('word.history.history'))
                    ->addComponent(
                        LocaleTableComponent::create()
                            ->setFlat()
                            ->setSearchable()
                            ->setDisablePagination()
                            ->setVuexNamespace('cms/table/items/dataTable')
                            ->setHeaderRoute(route('company.cms.table.item.table.headers', [
                                $this->company->id,
                                $this->cms->id,
                                $this->table->id,
                                'history'
                            ]))
                            ->setItemsRoute(route('company.cms.table.item.table.items', [
                                $this->company->id,
                                $this->cms->id,
                                $this->table->id,
                                'history'
                            ]))
                    )
            );
    }
}
