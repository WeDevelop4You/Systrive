<?php

namespace Domain\Cms\Columns\Options;

use Doctrine\DBAL\Exception;
use Domain\Cms\Columns\Attributes\Validation;
use Domain\Cms\Columns\Options\Types\PropertyDirtyColumnOption;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsModel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Utils\Validations;

class UniqueColumnOption extends AbstractColumnOption implements PropertyDirtyColumnOption, Validation
{
    protected function col(): int
    {
        return 6;
    }

    /**
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'unique';
    }

    /**
     * {@inheritDoc}
     */
    protected function defaultValue(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     *
     * @throws Exception
     */
    public function getProperty(ColumnDefinition $columnDefinition, Blueprint $table, CmsColumn $column): void
    {
        $index = "unique_{$column->table_id}_{$column->id}";

        if ($this->getValue()) {
            $columnDefinition->unique($index);
        } elseif (!empty($column->table_id)) {
            if (Arr::has($column->table->indexes(), $index)) {
                $table->dropUnique($index);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function isDirty(mixed $value): bool
    {
        return $this->getValue() !== $value;
    }

    /**
     * {@inheritDoc}
     */
    public function getValidation(FormRequest $request): Validations
    {
        $validation = $this->getValue()
            ? [Rule::unique(CmsModel::class)->ignore($request->item)]
            : [];

        return new Validations($validation);
    }

    /**
     * {@inheritDoc}
     */
    protected function inputComponent(bool $isEditing): AbstractInputComponent
    {
        return CheckboxInputComponent::create()->setLabel(trans('word.unique'));
    }

    /**
     * {@inheritDoc}
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations(['boolean', 'nullable']);
    }
}
