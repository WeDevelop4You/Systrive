<?php

namespace Domain\Cms\Columns\Options\Nullables;

use Domain\Cms\Columns\Definitions\Validation;
use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Columns\Options\Types\PropertyColumnOption;
use Domain\Cms\Models\CmsColumn;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Foundation\Http\FormRequest;
use Support\Utils\Validations;

abstract class AbstractNullableColumnOption extends AbstractColumnOption implements PropertyColumnOption, Validation
{
    /**
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'nullable';
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
     */
    public function getProperty(ColumnDefinition $columnDefinition, Blueprint $table, CmsColumn $column): void
    {
        $columnDefinition->nullable($this->getValue());
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
        return new Validations([$this->getValue() ? 'nullable' : 'required']);
    }

    /**
     * {@inheritDoc}
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations(['boolean', 'nullable']);
    }
}
