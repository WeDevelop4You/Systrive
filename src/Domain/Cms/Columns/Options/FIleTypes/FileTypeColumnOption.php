<?php

namespace Domain\Cms\Columns\Options\FIleTypes;

use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Columns\Options\Attributes\ComponentColumnOption;
use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\SelectInputComponent;
use Support\Client\Components\Layouts\ColComponent;

class FileTypeColumnOption extends AbstractColumnOption implements ComponentColumnOption
{
    /**
     * @inheritDoc
     */
    protected function getType(): string
    {
        return 'type';
    }

    /**
     * @inheritDoc
     */
    public function getDefault(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getFormComponent(bool $isEditing): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                SelectInputComponent::create()
                    ->setKey($this->getFormKey())
                    ->setItems($this->getItems())
                    ->setDefaultValue($this->getDefault())
            );
    }

    /**
     * @inheritDoc
     */
    public function getRequirements(FormRequest $request): array
    {
        return [];
    }

    private function getItems(): array
    {
    }
}
