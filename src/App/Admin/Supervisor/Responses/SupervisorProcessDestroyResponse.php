<?php

namespace App\Admin\Supervisor\Responses;

use Domain\Supervisor\Models\Supervisor;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\RequestAction;
use Support\Response\Components\Popups\Modals\DeleteModal;
use Support\Response\Response;

class SupervisorProcessDestroyResponse extends AbstractResponse
{
    protected function __construct(
        private readonly Supervisor $supervisor
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
                DeleteModal::create('supervisor')
                    ->addFooterDeleteButton(
                        RequestAction::create()->delete(
                            route('admin.admin.supervisor.process.destroy', [
                                $this->supervisor->id,
                            ])
                        )
                    )
                    ->addFooterCancelButton()
            );
    }
}
