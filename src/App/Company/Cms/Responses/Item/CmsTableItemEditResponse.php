<?php

namespace App\Company\Cms\Responses\Item;

use Domain\Cms\Helpers\CmsTableHelper;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;

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
                FormModal::create('cms/table/items/form')
                    ->setPersistent()
                    ->setTitle('word.edit.edit')
                    ->setForm(FormComponent::create()->setItems(
                        $this->table->formColumns->createFormStructure($this->model)->toArray()
                    ))
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'cms/table/items/update',
                            route('company.cms.table.item.edit', [
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
