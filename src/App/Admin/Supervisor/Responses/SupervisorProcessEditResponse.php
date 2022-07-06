<?php

namespace App\Admin\Supervisor\Responses;

use App\Admin\Supervisor\Forms\SupervisorProcessForm;
use App\Admin\Supervisor\Resources\SupervisorProcessResource;
use Domain\Supervisor\Models\Supervisor;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;

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
                            route('admin.admin.supervisor.process.edit', [
                                $this->supervisor->id,
                            ])
                        )
                    )
            );
    }
}
