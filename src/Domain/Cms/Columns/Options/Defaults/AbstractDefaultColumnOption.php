<?php

namespace Domain\Cms\Columns\Options\Defaults;

use Support\Utils\Validations;
use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Columns\Options\Types\PropertyDirtyColumnOption;
use Domain\Cms\Models\CmsColumn;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractDefaultColumnOption extends AbstractColumnOption implements PropertyDirtyColumnOption
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return "default";
    }

    /**
     * @inheritDoc
     */
    protected function defaultValue(): mixed
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
}
