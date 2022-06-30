<?php

namespace App\Admin\Supervisor\Responses;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Forms\FormComponent;
use Support\Response\Components\Forms\Helpers\ColWithInputHelper;
use Support\Response\Components\Forms\InputTypes\CodeEditorInputComponent;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;

class SupervisorProcessEditResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addPopup(
                FormModal::create('supervisor/processForm')
                    ->setPersistent()
                    ->setTitle(trans('word.edit.edit'))
                    ->setForm($this->createForm())
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()
                            ->dispatch(
                                'supervisor/update',
                                route('admin.admin.supervisor.process.edit')
                            )
                    )
            );
    }

    /**
     * @return FormComponent
     */
    private function createForm(): FormComponent
    {
        return FormComponent::create()
            ->addInput(
                ColWithInputHelper::create()
                    ->setInput(
                        CodeEditorInputComponent::create()
                            ->setKey('config')
                            ->setValue($this->getFileContent())
                    )
            );
    }

    private function getFileContent()
    {
        try {
            return File::get(storage_path('app/public/systrive-system.conf'));
        } catch (FileNotFoundException) {
            return '';
        }
    }
}
