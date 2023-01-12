<?php

namespace App\Admin\Supervisor\Responses;

use Domain\Supervisor\Models\Supervisor;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RequestAction;
use Support\Client\Components\Popups\Modals\DeleteModal;
use Support\Client\Response;

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
                            route('admin.supervisor.process.destroy', [
                                $this->supervisor->id,
                            ])
                        )
                    )
                    ->addFooterCancelButton()
            );
    }
}
