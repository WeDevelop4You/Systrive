<?php

namespace App\Admin\Translation\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\RequestAction;
use Support\Response\Components\Popups\Modals\DeleteModal;
use Support\Response\Response;
use WeDevelop4You\TranslationFinder\Models\TranslationKey;

class TranslationDestroyResponse extends AbstractResponse
{
    /**
     * TranslationDestroyResponse constructor.
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
            ->addPopup(
                DeleteModal::create('translations')
                    ->addFooterDeleteButton(
                        RequestAction::create()
                            ->delete(route('admin.admin.translation.destroy', [
                                $this->translationKey->id,
                            ]))
                    )
                    ->addFooterCancelButton()
            );
    }
}
