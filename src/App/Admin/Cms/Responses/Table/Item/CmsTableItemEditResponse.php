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

class CmsTableItemEditResponse extends AbstractResponse
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
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addPopup(
                FormModal::create('company/cms/table/items/form')
                    ->setPersistent()
                    ->setTitle('word.edit.edit')
                    ->setForm(
                        CmsTableHelper::create($this->table)->getFormStructure($this->model)
                    )
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'company/cms/table/items/update',
                            route('admin.company.cms.table.item.edit', [
                                $this->company->id,
                                $this->cms->id,
                                $this->table->id,
                                $this->model->id,
                            ])
                        )
                    )
            );
    }
}
