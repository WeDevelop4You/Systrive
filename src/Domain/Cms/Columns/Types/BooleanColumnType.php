<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\Defaults\DefaultBooleanColumnOption;
use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Models\CmsModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Enums\Component\Vuetify\VuetifyTableAlignmentType;
use Support\Helpers\DataTable\Build\Column;
use Support\Response\Components\Forms\Inputs\AbstractInputComponent;
use Support\Response\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Response\Components\Icons\IconComponent;

class BooleanColumnType extends AbstractColumnType
{
    protected function getOptions(): Collection
    {
        return Collection::make([
            new DefaultBooleanColumnOption(),
            new RowColColumnOption(),
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function getType(): string
    {
        return 'boolean';
    }

    /**
     * @inheritDoc
     */
    public function getColumnComponent(): Column
    {
        return Column::create($this->column->label, $this->column->key)
            ->setSortable()
            ->setSearchable()
            ->setAlignment(VuetifyTableAlignmentType::CENTER)
            ->setFormat(function (CmsModel $data) {
                if ($data->getAttribute($this->column->key)) {
                    return IconComponent::create()
                        ->setType(IconType::FAS_CHECK)
                        ->setColor(VuetifyColor::SUCCESS);
                }

                return IconComponent::create()
                    ->setType(IconType::FAS_TIMES)
                    ->setColor(VuetifyColor::ERROR);
            });
    }

    /**
     * @inheritDoc
     */
    public function getFormComponent(CmsModel $model): AbstractInputComponent
    {
        return CheckboxInputComponent::create()
            ->setKey($this->column->key)
            ->setLabel($this->column->label)
            ->setDefaultValue($this->getDefaultValue())
            ->setValue($model->getAttribute($this->column->key));
    }

    /**
     * @inheritDoc
     */
    protected function getValidation(FormRequest $request): array
    {
        return ['boolean'];
    }
}
