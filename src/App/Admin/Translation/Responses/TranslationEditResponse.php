<?php

namespace App\Admin\Translation\Responses;

use App\Admin\Translation\Resources\TranslationKeyResource;
use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\Form\FormType;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Forms\CustomFormComponent;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;
use WeDevelop4You\TranslationFinder\Models\TranslationKey;

class TranslationEditResponse extends AbstractResponse
{
    /**
     * TranslationEditResponse constructor.
     *
     * @param TranslationKey $translationKey
     */
    public function __construct(
        private readonly TranslationKey $translationKey
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addData(TranslationKeyResource::make($this->translationKey))
            ->addPopup(
                FormModal::create('translations/form')
                    ->setPersistent()
                    ->setTitle(trans('word.edit.edit'))
                    ->setForm(
                        CustomFormComponent::create()
                            ->setType(FormType::TRANSLATION)
                    )
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'translations/update',
                            route('admin.admin.translation.edit', [
                                $this->translationKey->id,
                            ])
                        )
                    )
            );
    }
}
