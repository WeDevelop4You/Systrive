<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\Defaults\DefaultBooleanColumnOption;
use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Models\CmsModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\DataTable\Build\Column;
use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Enums\Component\Vuetify\VuetifyTableAlignmentType;
use Support\Utils\Validations;

class BooleanColumnType extends AbstractColumnType
{
    protected function options(): Collection
    {
        return Collection::make([
            new DefaultBooleanColumnOption(),
            new RowColColumnOption(),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'boolean';
    }

    /**
     * {@inheritDoc}
     */
    protected function columnComponent(): Column
    {
        return Column::create($this->getLabel(), $this->getKey())
            ->setSortable()
            ->setSearchable()
            ->setAlignment(VuetifyTableAlignmentType::CENTER)
            ->setFormat(function (CmsModel $data) {
                if ($data->getAttribute($this->getKey())) {
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
     * {@inheritDoc}
     */
    protected function inputComponent(CmsModel $model): AbstractInputComponent
    {
        return CheckboxInputComponent::create()
            ->setDefaultValue($this->getPropertyValueDefault())
            ->setValue($model->getAttribute($this->getKey()));
    }

    /**
     * {@inheritDoc}
     */
    protected function validation(FormRequest $request): validations
    {
        return new Validations(['boolean']);
    }
}
