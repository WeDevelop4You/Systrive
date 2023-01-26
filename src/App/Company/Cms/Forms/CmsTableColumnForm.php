<?php

namespace App\Company\Cms\Forms;

use Domain\Cms\Columns\Attributes\ComponentOption;
use Domain\Cms\Enums\CmsColumnType;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Client\Components\Forms\Inputs\ConditionInputComponent;
use Support\Client\Components\Forms\Inputs\Custom\CustomSelectInputComponent;
use Support\Client\Components\Forms\Inputs\SelectInputComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;
use Support\Client\Components\Forms\Utils\KeyValueObject;
use Support\Client\Components\Forms\Utils\Logic;
use Support\Client\Components\Layouts\ColComponent;

class CmsTableColumnForm extends AbstractForm
{
    /**
     * CmsTableColumnForm constructor.
     *
     * @param bool $isEditing
     * @param bool $isEditable
     */
    public function __construct(
        private readonly bool $isEditing = false,
        private readonly bool $isEditable = false
    ) {
    }

    /**
     * {@inheritDoc}
     */
    protected function handle(): FormComponent
    {
        return FormComponent::create()
            ->setItems([
                InputColWrapper::create()
                    ->setCol(
                        ColComponent::create()->setMdCol(6)
                    )
                    ->setInput(
                        CheckboxInputComponent::create()
                            ->setLabel(trans('word.editable'))
                            ->setKey(CmsColumnTableMap::COL_EDITABLE)
                            ->setDisabled($this->isEditable)
                    ),
                InputColWrapper::create()
                    ->setCol(
                        ColComponent::create()->setMdCol(6)
                    )
                    ->setInput(
                        CheckboxInputComponent::create()
                            ->setLabel(trans('word.hidden'))
                            ->setKey(CmsColumnTableMap::COL_HIDDEN)
                            ->addHiddenLogic(
                                Logic::if('type.value')->setCompressing(CmsColumnType::RICH_TEXT->value)
                            )
                    ),
                InputColWrapper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setLabel(trans('word.label.label'))
                            ->setKey(CmsColumnTableMap::COL_LABEL)
                            ->setDisabled($this->isEditable)
                    ),
                InputColWrapper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setLabel(trans('word.key.key'))
                            ->setKey(CmsColumnTableMap::COL_KEY)
                            ->setDisabled($this->isEditable)
                    ),
                InputColWrapper::create()
                    ->setInput(
                        CustomSelectInputComponent::create()
                            ->setLabel(trans('word.after.column'))
                            ->setKey(CmsColumnTableMap::COL_AFTER)
                            ->setDisabled($this->isEditable)
                    ),
                InputColWrapper::create()
                    ->setInput(
                        SelectInputComponent::create()
                            ->setReturnObject()
                            ->setLabel(trans('word.type.type'))
                            ->setKey(CmsColumnTableMap::COL_TYPE)
                            ->setItems($this->createItems())
                            ->setDisabled($this->isEditable)
                    ),
                InputColWrapper::create()
                    ->setCondition(!$this->isEditable)
                    ->setInput(
                        ConditionInputComponent::create()
                            ->setPath('type.additional')
                            ->setVuexNamespace('cms/table/columns/form/data')
                    ),
            ]);
    }

    private function createItems()
    {
        return Collection::make(CmsColumnType::getVisibleValues())
            ->map(function (CmsColumnType $columnType) {
                return KeyValueObject::create()
                    ->setText($columnType->trans())
                    ->setValue($columnType->value)
                    ->setAdditionalData($columnType->additionalForm(false)->map(
                        fn (ComponentOption $option) => $option->getComponent($this->isEditing)->export()
                    ))
                    ->setDisabled($columnType === CmsColumnType::ID);
            })->toArray();
    }
}
