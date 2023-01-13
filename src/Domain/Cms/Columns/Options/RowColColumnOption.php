<?php

namespace Domain\Cms\Columns\Options;

use Domain\Cms\Columns\Options\Types\ComponentColumnOption;
use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\SelectInputComponent;
use Support\Client\Components\Forms\Utils\KeyValueObject;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Utils\Validations;

class RowColColumnOption extends AbstractColumnOption implements ComponentColumnOption
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return 'row_col';
    }

    /**
     * @inheritDoc
     */
    protected function defaultValue(): int
    {
        return 12;
    }

    /**
     * @inheritDoc
     */
    protected function inputComponent(bool $isEditing): AbstractInputComponent
    {
        return SelectInputComponent::create()
            ->setItems($this->getItems())
            ->setDefaultValue($this->defaultValue())
            ->setLabel(trans('word.field.component.length'));
    }

    /**
     * @inheritDoc
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations(['required', 'integer', 'between:1,12']);
    }

    /**
     * @return array
     */
    private function getItems(): array
    {
        foreach (range(1, 12) as $col) {
            $col = 13 - $col;

            $items[] = KeyValueObject::create()
                ->setValue($col)
                ->setText("12 / {$col}");
        }

        return $items;
    }
}
