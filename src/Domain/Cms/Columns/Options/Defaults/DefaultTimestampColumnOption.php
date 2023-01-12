<?php

namespace Domain\Cms\Columns\Options\Defaults;

use Domain\Cms\Models\CmsColumn;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Client\Components\Layouts\ColComponent;

class DefaultTimestampColumnOption extends AbstractDefaultColumnOption
{
    /**
     * DefaultTimestampColumnOption constructor.
     *
     * @param array $requirements
     */
    public function __construct(
        private readonly array $requirements,
    ) {
        //
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
        if ($this->getValue()) {
            $columnDefinition->useCurrent();
        } else {
            $columnDefinition->default(null);
        }
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
                    ->setVuexNamespace($this->getVuexNamespace())
                    ->setLabel(trans('word.default.use.current'))
            );
    }

    /**
     * @inheritDoc
     */
    public function getRequirements(FormRequest $request): array
    {
        return ['nullable', ...$this->requirements];
    }
}
