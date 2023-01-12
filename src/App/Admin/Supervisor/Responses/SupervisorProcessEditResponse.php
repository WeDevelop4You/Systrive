<?php

namespace App\Admin\Supervisor\Responses;

use App\Admin\Supervisor\Forms\SupervisorProcessForm;
use App\Admin\Supervisor\Resources\SupervisorProcessResource;
use Domain\Supervisor\Models\Supervisor;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;

class SupervisorProcessEditResponse extends AbstractResponse
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
            ->addData(SupervisorProcessResource::make($this->supervisor))
            ->addPopup(
                FormModal::create('supervisor/form')
                    ->setPersistent()
                    ->setTitle(trans('word.edit.edit'))
                    ->setForm(SupervisorProcessForm::create())
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'supervisor/update',
                            route('admin.supervisor.process.edit', [
                                $this->supervisor->id,
                            ])
                        )
                    )
            );
    }
}
