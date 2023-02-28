<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Definitions\DirtyColumn;
use Domain\Cms\Columns\Definitions\Validation;
use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Columns\Options\Types\ArgumentColumnOption;
use Domain\Cms\Columns\Options\Types\PropertyColumnOption;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsModel;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\Type;
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
use Support\Graphql\Definitions\Field;
use Support\Utils\Validations;

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
     * @param bool        $onlyInputs
     * @param string|null $prefix
     *
     * @return Collection
     */
    final public static function additionalForm(bool $onlyInputs = false, string|null $prefix = null): Collection
    {
        $instance = new static();

        $type = $instance->type();
        $options = $instance->options();

        if ($onlyInputs) {
            $options = $options->whereInstanceOf(AbstractColumnOption::class);
        }

        return $options->map(function ($option) use ($type, $prefix) {
            if ($option instanceof AbstractColumnOption) {
                $option->setPrefix($type);

                if (!is_null($prefix)) {
                    $option->setFormPrefix($prefix);
                }
            }

            return $option;
        });
    }

    /**
     * @return string
     */
    protected function getKey(): string
    {
        return $this->column->key;
    }

    /**
     * @return string
     */
    protected function getLabel(): string
    {
        return $this->column->label;
    }

    /**
     * @return Collection
     */
    protected function getProperties(): Collection
    {
        return $this->column->properties;
    }

    /**
     * @param Blueprint $table
     *
     * @return ColumnDefinition|ForeignIdColumnDefinition
     */
    final public function getDefinition(Blueprint $table): ColumnDefinition|ForeignIdColumnDefinition
    {
        $arguments = $this->getProperties()->filter(
            fn (AbstractColumnOption $option) => $option instanceof ArgumentColumnOption
        )->mapWithKeys(
            fn (ArgumentColumnOption $option) => [$option->getArgumentKey() => $option->getValue()]
        )->prepend($this->getKey(), 'column')->toArray();

        $column = App::call([$table, $this->type()], $arguments);

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

    /**
     * @param string $table
     *
     * @return array
     */
    final public function getGraphqlField(string $table): array
    {
        $type = $this->graphqlType($table);

        if ($this->getPropertyValueNullable()) {
            $type = Type::nonNull($type);
        }

        return Field::create(
            $this->getKey(),
            $type,
            $this->graphqlArguments(),
            $this->graphqlResolve()
        );
    }

    /**
     * @return InputObjectType
     */
    final public function getGraphqlFilter(): InputObjectType
    {
        return $this->graphqlFilter();
    }

    /**
     * @return Column
     */
    final public function getColumnComponent(): Column
    {
        return $this->columnComponent();
    }

    /**
     * @param CmsModel $model
     * @param bool     $readonly
     *
     * @return InputColWrapper
     */
    final public function getInputComponent(CmsModel $model, bool $readonly = false): InputColWrapper
    {
        return InputColWrapper::create()
            ->setCol(
                ColComponent::create()
                    ->setMdCol($this->getPropertyValue('row_col', 12))
            )
            ->setInput(
                $this->inputComponent($model)
                    ->setReadonly($readonly)
                    ->setKey($this->getKey())
                    ->setLabel($this->getLabel())
            );
    }

    /**
     * @param FormRequest $request
     *
     * @return array
     */
    final public function getValidations(FormRequest $request): array
    {
        $validations = $this->validation($request);

        $this->getProperties()
             ->filter(fn (AbstractColumnOption $option) => $option instanceof Validation)
             ->each(fn (Validation $option) => $validations->add($option->getValidation($request)));

        return $validations->toArray($this->getKey());
    }

    /**
     * @param string     $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    final public function getPropertyValue(string $key, mixed $default = null): mixed
    {
        return Collection::json(
            $this->column->getRawOriginal(CmsColumnTableMap::COL_PROPERTIES) ?? ''
        )->get("{$this->type()}_{$key}", $default);
    }

    /**
     * @return bool
     */
    final public function isPropertiesDirty(): bool
    {
        return $this->getProperties()
            ->filter(function (AbstractColumnOption $option) {
                $original = $this->getPropertyValue($option->getKey());

                return $option instanceof DirtyColumn && $option->isDirty($original);
            })->isNotEmpty();
    }

    /**
     * @return mixed
     */
    final protected function getPropertyValueDefault(): mixed
    {
        return $this->getPropertyValue('default');
    }

    /**
     * @return mixed
     */
    final protected function getPropertyValueNullable(): bool
    {
        return $this->getPropertyValue('nullable', false);
    }

    /**
     * @return Collection
     */
    abstract protected function options(): Collection;

    /**
     * @return string
     */
    abstract protected function type(): string;

    /**
     * @param string $table
     *
     * @return ListOfType|ObjectType|ScalarType
     */
    abstract protected function graphqlType(string $table): ObjectType|ListOfType|ScalarType;

    /**
     * @return InputObjectType|null
     */
    protected function graphqlFilter(): InputObjectType|null
    {
        return null;
    }

    /**
     * @return array|null
     */
    protected function graphqlArguments(): array|null
    {
        return null;
    }

    /**
     * @return callable|null
     */
    protected function graphqlResolve(): callable|null
    {
        return null;
    }

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
     * @return validations
     */
    abstract protected function validation(FormRequest $request): validations;
}
