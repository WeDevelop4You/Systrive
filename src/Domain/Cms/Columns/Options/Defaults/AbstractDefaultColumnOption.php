<?php

namespace Domain\Cms\Columns\Options\Defaults;

use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Columns\Options\Attributes\PropertyColumnOption;
use Domain\Cms\Models\CmsColumn;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractDefaultColumnOption extends AbstractColumnOption implements PropertyColumnOption
{
    /**
     * @inheritDoc
     */
    protected function getType(): string
    {
        return "default";
    }

    /**
     * @inheritDoc
     */
    public function getDefault(): mixed
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getProperty(ColumnDefinition $columnDefinition, Blueprint $table, CmsColumn $column): void
    {
        $columnDefinition->default($this->getValue());
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
    public function getValidation(FormRequest $request): array|string|object
    {
        return '';
    }
}
