<?php

namespace App\Admin\Cms\Responses\Table\Column;

use App\Admin\Cms\Forms\CmsTableColumnForm;
use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;

class CmsTableColumnEditResponse extends AbstractResponse
{
    public function __construct(
        private readonly Company $company,
        private readonly Cms $cms,
        private readonly string $key,
        private readonly bool $isEditing
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addData($this->key)
            ->addPopup(
                FormModal::create('company/cms/table/columns/form', withoutDataTableRefresh: true)
                    ->setPersistent()
                    ->setTitle('word.edit.column')
                    ->setForm(CmsTableColumnForm::create($this->isEditing))
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'company/cms/table/columns/process',
                            route('admin.company.cms.table.column.create', [
                                $this->company->id,
                                $this->cms->id,
                            ])
                        )
                    )
            );
    }
}
