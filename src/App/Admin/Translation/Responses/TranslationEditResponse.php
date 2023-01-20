<?php

namespace App\Admin\Translation\Responses;

use App\Admin\Translation\Forms\TranslationForm;
use App\Admin\Translation\Resources\TranslationResource;
use Domain\Translation\Models\TranslationKey;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;

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
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addData(TranslationResource::make($this->translationKey))
            ->addPopup(
                FormModal::create('translations/form')
                    ->setPersistent()
                    ->setTitle(trans('word.edit.edit'))
                    ->setForm(TranslationForm::create($this->translationKey))
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'translations/update',
                            route('admin.translation.edit', [
                                $this->translationKey->id,
                            ])
                        )
                    )
            );
    }
}
