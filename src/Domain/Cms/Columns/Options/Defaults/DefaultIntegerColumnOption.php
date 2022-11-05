<?php

namespace Domain\Cms\Columns\Options\Defaults;

use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Columns\Options\Attributes\PropertyColumnOption;
use Domain\Cms\Models\CmsColumn;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Foundation\Http\FormRequest;
use Support\Response\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Response\Components\Forms\Inputs\NumberInputComponent;
use Support\Response\Components\Forms\Inputs\TextInputComponent;
use Support\Response\Components\Layouts\ColComponent;

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
