<?php

namespace App\Company\Cms\Responses\Column;

use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Modals\DeleteModal;
use Support\Client\Response;

class CmsTableColumnDestroyResponse extends AbstractResponse
{
    public function __construct(
        private readonly string $key,
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addPopup(
                DeleteModal::create()
                    ->addFooterDeleteButton(
                        VuexAction::create()->dispatch(
                            'cms/table/columns/delete',
                            $this->key
                        )
                    )
                    ->addFooterCancelButton()
            );
    }
}
