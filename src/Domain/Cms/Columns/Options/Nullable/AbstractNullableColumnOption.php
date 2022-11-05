<?php

namespace Domain\Cms\Columns\Options\Nullable;

use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Columns\Options\Attributes\PropertyColumnOption;
use Domain\Cms\Models\CmsColumn;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractNullableColumnOption extends AbstractColumnOption implements PropertyColumnOption
{
    /**
     * @inheritDoc
     */
    protected function getType(): string
    {
        return 'nullable';
    }

    /**
     * @inheritDoc
     */
    public function getDefault(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getProperty(ColumnDefinition $columnDefinition, Blueprint $table, CmsColumn $column): void
    {
        $columnDefinition->nullable($this->getValue());
    }

    /**
     * @inheritDoc
     */
    public function isDirty(mixed $value): bool
    {
        return $this->getValue() !== $value;
    }

    /**
     * @inheritDoc
     */
    public function getValidation(FormRequest $request): string
    {
        return $this->getValue() ? 'nullable' : 'required';
    }

    /**
     * @inheritDoc
     */
    public function getRequirements(FormRequest $request): array
    {
        return ['boolean', 'nullable'];
    }
}
