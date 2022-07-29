<?php

namespace App\Admin\Supervisor\Responses;

use App\Admin\Supervisor\Forms\SupervisorProcessForm;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;

class SupervisorProcessCreateResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addPopup(
                FormModal::create('supervisor/form')
                    ->setPersistent()
                    ->setTitle(trans('word.create.create'))
                    ->setForm(SupervisorProcessForm::create())
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'supervisor/store',
                            route('admin.admin.supervisor.process.create')
                        )
                    )
            );
    }
}
