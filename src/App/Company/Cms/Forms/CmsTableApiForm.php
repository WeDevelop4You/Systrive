<?php

namespace App\Company\Cms\Forms;

use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\CmsTable;
use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Client\Components\Forms\Inputs\GroupCheckboxInputComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;
use Support\Client\Components\Forms\Utils\Logic;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Utils\ColOptionsComponent;

class CmsTableApiForm extends AbstractForm
{
    /**
     * CmsTableApiForm constructor
     *
     * @param CmsTable $table
     */
    protected function __construct(
        private readonly CmsTable $table
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): FormComponent
    {
        $mutationLogic = Logic::unless(CmsTableTableMap::COL_MUTABLE);
        $colOptions = ColOptionsComponent::create()
            ->setDefaultCol()
            ->setXlCol(2)
            ->setLgCol(3)
            ->setMdCol(4)
            ->setSmCol(6);

        return FormComponent::create()
            ->setItems([
                InputColWrapper::create()
                    ->setCol(
                        ColComponent::create()->setmdCol(
                            $this->isTable() ? 4 : 6
                        )
                    )
                    ->setInput(
                        CheckboxInputComponent::create()
                            ->setKey(CmsTableTableMap::COL_QUERYABLE)
                            ->setDefaultValue(false)
                            ->setLabel(trans('word.enable.query'))
                    ),
                InputColWrapper::create()
                    ->setCol(
                        ColComponent::create()->setmdCol(
                            $this->isTable() ? 4 : 6
                        )
                    )
                    ->setInput(
                        CheckboxInputComponent::create()
                            ->setKey(CmsTableTableMap::COL_MUTABLE)
                            ->setDefaultValue(false)
                            ->setLabel(trans('word.enable.mutation'))
                    ),
                InputColWrapper::create()
                    ->setCondition($this->isTable())
                    ->setCol(
                        ColComponent::create()->setmdCol(4)
                    )
                    ->setInput(
                        CheckboxInputComponent::create()
                            ->setKey(CmsTableTableMap::COL_DELETABLE)
                            ->setDefaultValue(false)
                            ->setLabel(trans('word.enable.deletable'))
                    ),
                InputColWrapper::create()->setInput(
                    TextInputComponent::create()
                        ->setKey(CmsTableTableMap::COL_QUERY)
                        ->setLabel(trans('word.query.name'))
                ),
                InputColWrapper::create()->setInput(
                    GroupCheckboxInputComponent::create()
                        ->setKey(CmsColumnTableMap::COL_SELECTABLE)
                        ->setLabel(trans('word.selectable'))
                        ->setColOptions($colOptions)
                ),
                InputColWrapper::create()
                    ->setCondition($this->isTable())
                    ->setInput(
                        GroupCheckboxInputComponent::create()
                            ->setKey(CmsColumnTableMap::COL_CREATABLE)
                            ->setLabel(trans('word.mutation.create'))
                            ->addHiddenLogic($mutationLogic)
                            ->setColOptions($colOptions)
                    ),
                InputColWrapper::create()->setInput(
                    GroupCheckboxInputComponent::create()
                        ->setKey(CmsColumnTableMap::COL_UPDATABLE)
                        ->setLabel($this->isTable() ? trans('word.mutation.update') : trans('word.mutation.mutation'))
                        ->addHiddenLogic($mutationLogic)
                        ->setColOptions($colOptions)
                ),
            ]);
    }

    /**
     * @return bool
     */
    private function isTable(): bool
    {
        return $this->table->is_table;
    }
}
