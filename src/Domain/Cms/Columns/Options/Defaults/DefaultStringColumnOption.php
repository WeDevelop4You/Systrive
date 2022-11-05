<?php

namespace Domain\Cms\Columns\Options\Defaults;

use Illuminate\Foundation\Http\FormRequest;
use Support\Response\Components\Forms\Inputs\TextInputComponent;
use Support\Response\Components\Layouts\ColComponent;

class DefaultStringColumnOption extends AbstractDefaultColumnOption
{
    /**
     * @inheritDoc
     */
    public function getFormComponent(bool $isEditing): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                TextInputComponent::create()
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
        return ['nullable', 'string'];
    }
}
