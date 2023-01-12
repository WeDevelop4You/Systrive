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
use Illuminate\Database\Schema\ForeignIdColumnDefinition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\DataTable\Build\Column;

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
    final public static function getOptions(): Collection
    {
        $instance = new static();

        return $instance->options()->map(
            fn (AbstractColumnOption $option) => $option->setPrefix($instance->type())
        );
    }

    /**
     * @return string
     */
    private function getKey(): string
    {
        return $this->column->key;
    }

    /**
     * @return Collection
     */
    private function getProperties(): Collection
    {
        return $this->column->properties;
    }

    /**
     * @return array
     */
    private function getArguments(): array
    {
        return $this->getProperties()->filter(
            fn (AbstractColumnOption $option) => $option instanceof ArgumentColumnOption
        )->mapWithKeys(
            fn (ArgumentColumnOption $option) => [$option->getArgumentKey() => $option->getValue()]
        )->prepend($this->getKey(), 'column')->toArray();
    }

    /**
     * @param Blueprint $table
     *
     * @return ColumnDefinition|ForeignIdColumnDefinition
     */
    final public function getDefinition(Blueprint $table): ColumnDefinition|ForeignIdColumnDefinition
    {
        $column = App::call([$table, $this->type()], $this->getArguments());

        $this->getProperties()->filter(
            fn (AbstractColumnOption $option) => $option instanceof PropertyColumnOption
        )->each(function (PropertyColumnOption $option) use ($column, $table) {
            $original = $this->getPropertyValue($option->getKey());

            if ($option->isDirty($original)) {
                $option->getProperty($column, $table, $this->column);
            }
        });

        return $column;
    }

    final public function getColumnComponent(): Column
    {
        return $this->columnComponent();
    }

    final public function getInputComponent(CmsModel $model, bool $readonly = false): InputColWrapper
    {
        $input = $this->inputComponent($model)->setReadonly($readonly);
        $col = ColComponent::create()->setMdCol($this->getPropertyValue('row_col', 12));

        return InputColWrapper::create()->setCol($col)->setInput($input);
    }

    final public function getValidations(FormRequest $request): array
    {
        return $this->getProperties()
            ->filter(fn (AbstractColumnOption $option) => $option instanceof ValidationColumnOption)
            ->map(fn (ValidationColumnOption $option) => $option->getValidation($request))
            ->add($this->validation($request))
            ->flatten()
            ->filter()
            ->toArray();
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
     * @param string     $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    final protected function getPropertyValue(string $key, mixed $default = null): mixed
    {
        return Collection::json(
            $this->column->getRawOriginal(CmsColumnTableMap::COL_PROPERTIES) ?? ''
        )->get("{$this->type()}_{$key}", $default);
    }

    /**
     * @return mixed
     */
    final protected function getPropertyValueDefault(): mixed
    {
        return $this->getPropertyValue('default');
    }

    /**
     *
     * @return string
     */
    abstract protected function type(): string;

    /**
     * @return Collection
     */
    abstract protected function options(): Collection;

    /**
     * @return Column
     */
    abstract protected function columnComponent(): Column;

    /**
     * @param CmsModel $model
     *
     * @return AbstractInputComponent
     */
    abstract protected function inputComponent(CmsModel $model): AbstractInputComponent;

    /**
     * @param FormRequest $request
     *
     * @return array
     */
    abstract protected function validation(FormRequest $request): array;
}
