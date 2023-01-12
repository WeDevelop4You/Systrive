<?php

namespace Domain\Cms\Columns\Options\Defaults;

use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Client\Components\Layouts\ColComponent;

class DefaultBooleanColumnOption extends AbstractDefaultColumnOption
{
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
        return ['nullable', 'boolean'];
    }
}
