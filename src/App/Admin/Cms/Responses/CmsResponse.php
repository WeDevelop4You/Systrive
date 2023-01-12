<?php

namespace App\Admin\Cms\Responses;

use App\Admin\Cms\Forms\CmsForm;
use App\Admin\Cms\Resources\CmsCreateResource;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;

class CmsResponse extends AbstractResponse
{
    public function __construct(
        private readonly Company $company
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addData(CmsCreateResource::make($this->company))
            ->addPopup(
                FormModal::create('company/cms/form')
                    ->setPersistent()
                    ->setTitle(trans('word.create.create'))
                    ->setForm(CmsForm::create($this->company))
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'cms/store',
                            route('admin.company.cms.create', $this->company->id)
                        )
                    )
            );
    }
}
