<?php

namespace Domain\Cms\Columns\Options\Defaults;

use Domain\Cms\Models\CmsColumn;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Utils\Validations;

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

    protected function col(): int
    {
        return 6;
    }

    /**
     * @inheritDoc
     */
    protected function defaultValue(): bool
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
    protected function inputComponent(bool $isEditing): AbstractInputComponent
    {
        return CheckboxInputComponent::create()->setLabel(trans('word.default.use.current'));
    }

    /**
     * @inheritDoc
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations(['nullable', ...$this->requirements]);
    }
}
