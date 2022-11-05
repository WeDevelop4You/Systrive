<?php

namespace Domain\Cms\Columns\Options;

use Domain\Cms\Columns\Options\Attributes\ArgumentColumnOption;
use Illuminate\Foundation\Http\FormRequest;
use Support\Response\Components\Forms\Inputs\NumberInputComponent;
use Support\Response\Components\Layouts\ColComponent;

class PlacesColumnOption extends AbstractColumnOption implements ArgumentColumnOption
{
    public function __construct(
        private readonly array $requirements,
        private readonly ?int $default = 2
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function getType(): string
    {
        return 'places';
    }

    /**
     * @inheritDoc
     */
    public function getDefault(): ?int
    {
        return $this->default;
    }

    /**
     * @inheritDoc
     */
    public function getArgumentKey(): string
    {
        return 'places';
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
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getFormComponent(bool $isEditing): ColComponent
    {
        return ColComponent::create()
            ->setMdCol(6)
            ->setComponent(
                NumberInputComponent::create()
                    ->setKey($this->getFormKey())
                    ->setLabel(trans('word.total.after.dot'))
                    ->setVuexNamespace($this->getVuexNamespace())
                    ->setDefaultValue($this->getDefault())
            );
    }

    /**
     * @inheritDoc
     */
    public function getRequirements(FormRequest $request): array
    {
        $totalKey = $this->getOtherFormKey('total');

        return ['nullable', "lt:{$totalKey}", ...$this->requirements];
    }
}
