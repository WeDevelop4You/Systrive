<?php

namespace App\Admin\Cms\Responses\Table\Column;

use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Popups\Modals\DeleteModal;
use Support\Response\Response;

class CmsTableColumnDestroyResponse extends AbstractResponse
{
    public function __construct(
        private readonly string $key,
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
                DeleteModal::create()
                    ->addFooterDeleteButton(
                        VuexAction::create()->dispatch(
                            'company/cms/table/columns/delete',
                            $this->key
                        )
                    )
                    ->addFooterCancelButton()
            );
    }
}
