<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Columns\Options\Attributes\ArgumentColumnOption;
use Domain\Cms\Columns\Options\Attributes\PropertyColumnOption;
use Domain\Cms\Columns\Options\Attributes\ValidationColumnOption;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsModel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Support\Helpers\DataTable\Build\Column;
use Support\Response\Components\Forms\Inputs\AbstractInputComponent;

abstract class AbstractColumnType
{
    /**
     * @var CmsColumn
     */
    protected readonly CmsColumn $column;

    /**
     * @param CmsColumn $column
     *
     * @return static
     */
    final public static function create(CmsColumn $column): static
    {
        $instance = new static();
        $instance->column = $column;

        return $instance;
    }

    /**
     * @return Collection
     */
    final public static function options(): Collection
    {
        $instance = new static();

        return $instance->getOptions()->map(
            fn (AbstractColumnOption $option) => $option->setPrefix($instance->getType())
        );
    }

    /**
     * @return Collection
     */
    private function getProperties(): Collection
    {
        return $this->column->properties;
    }

    /**
     * @param string     $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    final protected function getPropertyValue(string $key, mixed $default = null): mixed
    {
        return Collection::json(
            $this->column->getRawOriginal(CmsColumnTableMap::PROPERTIES) ?? ''
        )->get("{$this->getType()}_{$key}", $default);
    }

    /**
     * @return mixed
     */
    final protected function getDefaultValue(): mixed
    {
        return $this->getPropertyValue('default');
    }

    /**
     * @return int
     */
    final public function getColValue(): int
    {
        return $this->getPropertyValue('row_col', 12);
    }

    /**
     * @return bool
     */
    final public function isPropertiesDirty(): bool
    {
        return $this->getProperties()
            ->filter(function (AbstractColumnOption $option) {
                $original = $this->getPropertyValue($option->getKey());

                return $option instanceof ValidationColumnOption && $option->isDirty($original);
            })->isNotEmpty();
    }

    /**
     * @param Blueprint $table
     *
     * @return ColumnDefinition
     */
    final public function getBlueprint(Blueprint $table): ColumnDefinition
    {
        $arguments = $this->getProperties()->filter(
            fn (AbstractColumnOption $option) => $option instanceof ArgumentColumnOption
        )->mapWithKeys(
            fn (ArgumentColumnOption $option) => [$option->getArgumentKey() => $option->getValue()]
        )->toArray();

        $column = App::call(
            [$table, $this->getType()],
            ['column' => $this->column->key, ...$arguments]
        );

        $this->getProperties()
            ->filter(fn (AbstractColumnOption $option) => $option instanceof PropertyColumnOption)
            ->each(function (PropertyColumnOption $option) use ($column, $table) {
                $original = $this->getPropertyValue($option->getKey());

                if ($option->isDirty($original)) {
                    $option->getProperty($column, $table, $this->column);
                }
            });

        return $column;
    }

    final public function getRule(FormRequest $request): array
    {
        return $this->getProperties()
            ->filter(fn (AbstractColumnOption $option) => $option instanceof ValidationColumnOption)
            ->map(fn (ValidationColumnOption $option) => $option->getValidation($request))
            ->add($this->getValidation($request))
            ->flatten()
            ->filter()
            ->toArray();
    }

    /**
     * @return Collection
     */
    abstract protected function getOptions(): Collection;

    /**
     *
     * @return string
     */
    abstract protected function getType(): string;

    /**
     * @return Column
     */
    abstract public function getColumnComponent(): Column;

    /**
     * @param CmsModel $model
     *
     * @return AbstractInputComponent
     */
    abstract public function getFormComponent(CmsModel $model): AbstractInputComponent;

    /**
     * @param FormRequest $request
     *
     * @return array
     */
    abstract protected function getValidation(FormRequest $request): array;
}
