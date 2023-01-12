<?php

namespace App\Admin\Translation\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RequestAction;
use Support\Client\Components\Popups\Modals\DeleteModal;
use Support\Client\Response;
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
                            ->delete(route('admin.translation.destroy', [
                                $this->translationKey->id,
                            ]))
                    )
                    ->addFooterCancelButton()
            );
    }
}
