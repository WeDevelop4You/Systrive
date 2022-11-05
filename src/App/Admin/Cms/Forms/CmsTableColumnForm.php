<?php

namespace App\Admin\Cms\Forms;

use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Enums\CmsColumnType;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Models\CmsColumn;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractForm;
use Support\Enums\Component\Form\FormSelectInputType;
use Support\Response\Components\Forms\AbstractFormComponent;
use Support\Response\Components\Forms\FormComponent;
use Support\Response\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Response\Components\Forms\Inputs\ConditionInputComponent;
use Support\Response\Components\Forms\Inputs\Custom\CustomSelectInputComponent;
use Support\Response\Components\Forms\Inputs\SelectInputComponent;
use Support\Response\Components\Forms\Inputs\TextInputComponent;
use Support\Response\Components\Forms\Utils\InputColWrapper;
use Support\Response\Components\Forms\Utils\KeyValueObject;
use Support\Response\Components\Layouts\ColComponent;

class CmsTableColumnForm extends AbstractForm
{
    /**
     * CmsTableColumnForm constructor.
     *
     * @param bool $isEditing
     */
    public function __construct(
        private readonly bool $isEditing = false
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): AbstractFormComponent
    {
        $items = Collection::make(CmsColumnType::getVisibleValues())
            ->map(function (CmsColumnType $columnType) {
                return KeyValueObject::create()
                    ->setText($columnType->trans())
                    ->setValue($columnType->value)
                    ->setAdditionalData($columnType->options()->map(
                        fn (AbstractColumnOption $option) => $option->getFormComponent(
                            $this->isEditing
                        )->export()
                    ));
            })->toArray();

        return FormComponent::create()
            ->setInputs([
                InputColWrapper::create()
                    ->setCol(
                        ColComponent::create()->setMdCol(6)
                    )
                    ->setInput(
                        CheckboxInputComponent::create()
                            ->setLabel(trans('word.editable'))
                            ->setKey(CmsColumnTableMap::EDITABLE)
                    ),
                InputColWrapper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setLabel(trans('word.label.label'))
                            ->setKey(CmsColumnTableMap::LABEL)
                    ),
                InputColWrapper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setLabel(trans('word.key.key'))
                            ->setKey(CmsColumnTableMap::KEY)
                    ),
                InputColWrapper::create()
                    ->setInput(
                        CustomSelectInputComponent::create()
                            ->setLabel(trans('word.after.column'))
                            ->setKey(CmsColumnTableMap::AFTER)
                            ->setType(FormSelectInputType::TABLE_COLUMN)
                    ),
                InputColWrapper::create()
                    ->setInput(
                        SelectInputComponent::create()
                            ->setReturnObject()
                            ->setLabel(trans('word.type.type'))
                            ->setKey(CmsColumnTableMap::TYPE)
                            ->setItems($items)
                    ),
                InputColWrapper::create()
                    ->setInput(
                        ConditionInputComponent::create()
                            ->setPath('type.additional')
                            ->setVuexNamespace('company/cms/table/columns/form/data')
                    )
            ]);
    }
}
