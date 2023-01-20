<?php

namespace Domain\Cms\Columns\Options\FIle;

use Domain\Cms\Columns\Attributes\Validation;
use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Columns\Options\Types\ComponentColumnOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\SelectInputComponent;
use Support\Client\Components\Forms\Utils\KeyValueObject;
use Support\Client\Components\Forms\Utils\Logic;
use Support\Utils\Validations;

class MaxFileColumnOption extends AbstractColumnOption implements ComponentColumnOption, Validation
{
    /**
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'max';
    }

    /**
     * {@inheritDoc}
     */
    protected function defaultValue(): int
    {
        return 5;
    }

    /**
     * {@inheritDoc}
     */
    public function getValidation(FormRequest $request): Validations
    {
        return new Validations(["max:{$this->max()}"]);
    }

    /**
     * {@inheritDoc}
     */
    protected function inputComponent(bool $isEditing): AbstractInputComponent
    {
        return SelectInputComponent::create()
            ->setItems($this->getItems())
            ->setDefaultValue($this->defaultValue())
            ->setLabel(trans('word.max.files'))
            ->addHiddenLogic(
                Logic::unless($this->getOtherFormKey('multiple'))
            );
    }

    /**
     * {@inheritDoc}
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations(['required', 'integer', 'between:1,10']);
    }

    /**
     * @return array
     */
    private function getItems(): array
    {
        return Collection::times(
            10,
            fn (int $max) => KeyValueObject::create()->setValue($max)->setText($max)
        )->toArray();
    }

    private function max()
    {
        $isMultiple = $this->getProperties(
            $this->getOtherKey('multiple'),
            false
        );

        return $isMultiple ? $this->getValue() : 1;
    }
}
