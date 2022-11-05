<?php

namespace App\Admin\Cms\Forms;

use Domain\Cms\Mappings\CmsTableTableMap;
use Support\Abstracts\AbstractForm;
use Support\Response\Components\Forms\AbstractFormComponent;
use Support\Response\Components\Forms\FormComponent;
use Support\Response\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Response\Components\Forms\Inputs\TextInputComponent;
use Support\Response\Components\Forms\Utils\InputColWrapper;
use Support\Response\Components\Layouts\ColComponent;

class CmsTableForm extends AbstractForm
{
    /**
     * @inheritDoc
     */
    protected function handle(): AbstractFormComponent
    {
        return FormComponent::create()
            ->addClass('mb-4')
            ->setInputs([
                InputColWrapper::create()
                    ->setInput(
                        CheckboxInputComponent::create()
                            ->setKey(CmsTableTableMap::EDITABLE)
                            ->setLabel(trans('word.editable'))
                    ),
                InputColWrapper::create()
                    ->setCol(
                        ColComponent::create()
                            ->setMdCol(6)
                    )
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey(CmsTableTableMap::LABEL)
                            ->setLabel(trans('word.label.label'))
                    ),
                InputColWrapper::create()
                    ->setCol(
                        ColComponent::create()
                            ->setMdCol(6)
                    )
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey(CmsTableTableMap::NAME)
                            ->setCounter(64)
                            ->setLabel(trans('word.table.name'))
                    ),
            ]);
    }
}
