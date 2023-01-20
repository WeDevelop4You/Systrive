<?php

namespace App\Company\Cms\Responses\Column;

use App\Company\Cms\Forms\CmsTableColumnForm;
use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;

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
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addData($this->key)
            ->addPopup(
                FormModal::create('cms/table/columns/form', withoutDataTableRefresh: true)
                    ->setPersistent()
                    ->setTitle('word.edit.column')
                    ->setForm(CmsTableColumnForm::create(
                        $this->isEditing,
                        \in_array($this->key, CmsTableTableMap::REQUIRED_COLUMNS)
                    ))
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
