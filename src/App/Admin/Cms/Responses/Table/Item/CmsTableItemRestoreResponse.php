<?php

namespace App\Admin\Cms\Responses\Table\Item;

use Domain\Cms\Helpers\CmsTableHelper;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\RequestAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;

class CmsTableItemRestoreResponse extends AbstractResponse
{
    /**
     * CmsTableItemRestoreResponse constructor.
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
            ->addAction(VuexAction::create()->dispatch(
                'company/cms/table/items/init',
                'restoreForm'
            ))
            ->addPopup(
                FormModal::create('company/cms/table/items/restoreForm')
                    ->setPersistent()
                    ->setWidth(800)
                    ->setTitle('word.show.show')
                    ->setForm(
                        CmsTableHelper::create($this->table)->getFormStructure($this->model, true)
                    )
                    ->addFooterCancelButton()
                    ->addFooterButton(
                        ButtonComponent::create()
                            ->setColor()
                            ->setTitle(trans('word.restore.restore'))
                            ->setAction(
                                RequestAction::create()->put(
                                    route('admin.company.cms.table.item.history.restore', [
                                        $this->company->id,
                                        $this->cms->id,
                                        $this->table->id,
                                        $this->model->id,
                                    ])
                                )
                            )
                    )
            );
    }
}
