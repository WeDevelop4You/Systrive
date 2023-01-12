<?php

namespace Domain\Cms\Columns\Options\Defaults;

use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\NumberInputComponent;
use Support\Client\Components\Layouts\ColComponent;

class DefaultIntegerColumnOption extends AbstractDefaultColumnOption
{
    /**
     * DefaultIntegerColumnOption constructor.
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
    public function getFormComponent(bool $isEditing): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                NumberInputComponent::create()
                    ->setKey($this->getFormKey())
                    ->setVuexNamespace($this->getVuexNamespace())
                    ->setLabel(trans('word.default.value'))
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
