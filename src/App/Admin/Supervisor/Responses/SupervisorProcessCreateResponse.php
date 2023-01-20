<?php

namespace App\Admin\Supervisor\Responses;

use App\Admin\Supervisor\Forms\SupervisorProcessForm;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;

class SupervisorProcessCreateResponse extends AbstractResponse
{
    /**
     * {@inheritDoc}
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
                            route('admin.supervisor.process.create')
                        )
                    )
            );
    }
}
