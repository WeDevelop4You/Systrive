<?php

namespace App\Admin\Cms\Responses\Table\Item;

use Domain\Cms\Helpers\CmsTableHelper;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;

class CmsTableItemCreateResponse extends AbstractResponse
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
                FormModal::create('company/cms/table/items/form')
                    ->setPersistent()
                    ->setTitle('word.create.create')
                    ->setForm(
                        CmsTableHelper::create($this->table)->getFormStructure(new CmsModel())
                    )
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'company/cms/table/items/store',
                            route('admin.company.cms.table.item.create', [
                                $this->company->id,
                                $this->cms->id,
                                $this->table->id,
                            ])
                        )
                    )
            );
    }
}
