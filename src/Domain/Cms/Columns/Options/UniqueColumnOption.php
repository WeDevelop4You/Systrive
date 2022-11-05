<?php

namespace Domain\Cms\Columns\Options;

use Doctrine\DBAL\Exception;
use Domain\Cms\Columns\Options\Attributes\PropertyColumnOption;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsModel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\isEmpty;

use Support\Response\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Response\Components\Layouts\ColComponent;

class UniqueColumnOption extends AbstractColumnOption implements PropertyColumnOption
{
    /**
     * @inheritDoc
     */
    protected function getType(): string
    {
        return 'unique';
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
     *
     * @throws Exception
     */
    public function getProperty(ColumnDefinition $columnDefinition, Blueprint $table, CmsColumn $column): void
    {
        $index = "unique_{$column->table_id}_{$column->id}";

        if ($this->getValue()) {
            $columnDefinition->unique($index);
        } elseif (!isEmpty($column->table_id)) {
            $indexes = Schema::connection('cms')
                ->getConnection()
                ->getDoctrineSchemaManager()
                ->listTableIndexes($column->table->name);

            if (\array_key_exists($index, $indexes)) {
                $table->dropUnique($index);
            }
        }
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
        return $this->getValue()
            ? Rule::unique(CmsModel::class)->ignore($request->item)
            : false;
    }

    /**
     * @inheritDoc
     */
    public function getFormComponent(bool $isEditing): ColComponent
    {
        return ColComponent::create()
            ->setMdCol(6)
            ->setComponent(
                CheckboxInputComponent::create()
                    ->setKey($this->getFormKey())
                    ->setLabel(trans('word.unique'))
                    ->setVuexNamespace($this->getVuexNameSpace())
            );
    }

    /**
     * @inheritDoc
     */
    public function getRequirements(FormRequest $request): array
    {
        return ['boolean', 'nullable'];
    }
}
