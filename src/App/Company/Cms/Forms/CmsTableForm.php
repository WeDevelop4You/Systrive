<?php

namespace App\Company\Cms\Forms;

use Domain\Cms\Mappings\CmsTableTableMap;
use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;
use Support\Client\Components\Layouts\ColComponent;

class CmsTableForm extends AbstractForm
{
    public function __construct(
        private readonly bool $isEditing = false,
    ) {
       //
    }

    /**
     * {@inheritDoc}
     */
    protected function handle(): FormComponent
    {
        return FormComponent::create()
            ->setClass('mb-4')
            ->setItems([
                InputColWrapper::create()
                    ->setCol(
                        ColComponent::create()
                            ->setMdCol($this->isEditing ? 12 : 6)
                    )
                    ->setInput(
                        CheckboxInputComponent::create()
                            ->setKey(CmsTableTableMap::COL_EDITABLE)
                            ->setLabel(trans('word.editable'))
                    ),
                InputColWrapper::create()
                    ->setCondition(!$this->isEditing)
                    ->setCol(
                        ColComponent::create()
                            ->setMdCol(6)
                    )
                    ->setInput(
                        CheckboxInputComponent::create()
                            ->setKey(CmsTableTableMap::COL_IS_TABLE)
                            ->setLabel(trans('word.table'))
                    ),
                InputColWrapper::create()
                    ->setCol(
                        ColComponent::create()
                            ->setMdCol(6)
                    )
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey(CmsTableTableMap::COL_LABEL)
                            ->setLabel(trans('word.label.label'))
                    ),
                InputColWrapper::create()
                    ->setCol(
                        ColComponent::create()
                            ->setMdCol(6)
                    )
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey(CmsTableTableMap::COL_NAME)
                            ->setCounter(64)
                            ->setLabel(trans('word.table.name'))
                    ),
            ]);
    }
}
