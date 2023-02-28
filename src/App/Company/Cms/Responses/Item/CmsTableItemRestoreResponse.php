<?php

namespace App\Company\Cms\Responses\Item;

use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\BtnComponentType;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;

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
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addAction(VuexAction::create()->dispatch(
                'cms/table/items/init',
                'restoreForm'
            ))
            ->addPopup(
                FormModal::create('cms/table/items/restoreForm')
                    ->setPersistent()
                    ->setWidth(800)
                    ->setTitle('word.show.show')
                    ->setForm(FormComponent::create()->setItems(
                        $this->table->formColumns->createFormStructure(
                            $this->model->load([
                                'files' => fn (MorphMany $query) => $query->withTrashed(),
                            ]),
                            true
                        )->toArray()
                    ))
                    ->addFooterCancelButton()
                    ->addFooter(
                        BtnComponentType::create()
                            ->setColor()
                            ->setTitle(trans('word.restore.restore'))
                            ->setAction(
                                RequestAction::create()->put(
                                    route('company.cms.table.item.history.restore', [
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
