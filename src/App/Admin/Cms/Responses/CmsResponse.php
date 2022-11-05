<?php

namespace App\Admin\Cms\Responses;

use App\Admin\Cms\Resources\CmsCreateResource;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\Form\FormType;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Forms\CustomFormComponent;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;

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
                    ->setForm(CustomFormComponent::create()->setType(FormType::CMS))
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'company/cms/store',
                            route('admin.sa.company.cms.create', $this->company->id)
                        )
                    )
            );
    }
}
