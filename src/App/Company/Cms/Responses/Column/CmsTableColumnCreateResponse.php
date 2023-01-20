<?php

namespace App\Company\Cms\Responses\Column;

use App\Company\Cms\Forms\CmsTableColumnForm;
use App\Company\Cms\Resources\CmsTableColumnResource;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsColumn;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;

class CmsTableColumnCreateResponse extends AbstractResponse
{
    public function __construct(
        private readonly Company $company,
        private readonly Cms $cms,
        private readonly bool $isEditing
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addData(CmsTableColumnResource::make(new CmsColumn()))
            ->addPopup(
                FormModal::create('cms/table/columns/form', withoutDataTableRefresh: true)
                    ->setPersistent()
                    ->setTitle('word.create.column')
                    ->setForm(CmsTableColumnForm::create($this->isEditing))
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'cms/table/columns/process',
                            route('company.cms.table.column.create', [
                                $this->company->id,
                                $this->cms->id,
                            ])
                        )
                    )
            );
    }
}
