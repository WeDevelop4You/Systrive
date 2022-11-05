<?php

namespace Domain\Cms\Columns\Options;

use Domain\Cms\Columns\Options\Attributes\ArgumentColumnOption;
use Illuminate\Foundation\Http\FormRequest;
use Support\Response\Components\Forms\Inputs\NumberInputComponent;
use Support\Response\Components\Layouts\ColComponent;

class MaxLengthColumnOption extends AbstractColumnOption implements ArgumentColumnOption
{
    public function __construct(
        private readonly int $default
    ) {

    }

    /**
     * @inheritDoc
     */
    protected function getType(): string
    {
        return 'max_length';
    }

    /**
     * @inheritDoc
     */
    public function getDefault(): int
    {
        return $this->default;
    }

    /**
     * @inheritDoc
     */
    public function isDirty(mixed $value): bool
    {
        return $this->getValue() !== $value;
    }

    /**
     * @return string
     */
    public function getArgumentKey(): string
    {
        return 'length';
    }

    /**
     * @inheritDoc
     */
    public function getValidation(FormRequest $request): array|string
    {
        return "max:{$this->getValue()}";
    }

    /**
     * @param bool $isEditing *
     *
     * @inheritDoc
     */
    public function getFormComponent(bool $isEditing): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                NumberInputComponent::create()
                    ->setKey($this->getFormKey())
                    ->setDefaultValue($this->getDefault())
                    ->setLabel(trans('word.max.length'))
                    ->setVuexNamespace($this->getVuexNameSpace())
            );
    }

    /**
     * @inheritDoc
     */
    public function getRequirements(FormRequest $request): array
    {
        return ['required', 'integer', "between:1,{$this->default}"];
    }
}
