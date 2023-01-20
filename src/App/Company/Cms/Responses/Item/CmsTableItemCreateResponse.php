<?php

namespace App\Company\Cms\Responses\Item;

use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;

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
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addPopup(
                FormModal::create('cms/table/items/form')
                    ->setPersistent()
                    ->setTitle('word.create.create')
                    ->setForm(FormComponent::create()->setItems(
                        $this->table->formColumns->createFormStructure(new CmsModel())->toArray()
                    ))
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'cms/table/items/store',
                            route('company.cms.table.item.create', [
                                $this->company->id,
                                $this->cms->id,
                                $this->table->id,
                            ])
                        )
                    )
            );
    }
}
