<?php

namespace Domain\Cms\Columns\Options;

use Domain\Cms\Columns\Options\Attributes\ComponentColumnOption;
use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\SelectInputComponent;
use Support\Client\Components\Forms\Utils\KeyValueObject;
use Support\Client\Components\Layouts\ColComponent;

class RowColColumnOption extends AbstractColumnOption implements ComponentColumnOption
{
    /**
     * @inheritDoc
     */
    protected function getType(): string
    {
        return 'row_col';
    }

    /**
     * @inheritDoc
     */
    public function getDefault(): int
    {
        return 12;
    }

    /**
     * @inheritDoc
     */
    public function getFormComponent(bool $isEditing): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                SelectInputComponent::create()
                    ->setKey($this->getFormKey())
                    ->setItems($this->getItems())
                    ->setDefaultValue($this->getDefault())
                    ->setVuexNamespace($this->getVuexNameSpace())
                    ->setLabel(trans('word.field.component.length'))
            );
    }

    /**
     * @inheritDoc
     */
    public function getRequirements(FormRequest $request): array
    {
        return ['required', 'integer', 'between:1,12'];
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
