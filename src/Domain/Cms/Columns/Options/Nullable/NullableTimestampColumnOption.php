<?php

namespace Domain\Cms\Columns\Options\Nullable;

use Domain\Cms\Models\CmsColumn;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\Carbon;
use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Client\Components\Layouts\ColComponent;

class NullableTimestampColumnOption extends AbstractNullableColumnOption
{
    public function __construct(
        private readonly ?string $type
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    public function getProperty(ColumnDefinition $columnDefinition, Blueprint $table, CmsColumn $column): void
    {
        parent::getProperty($columnDefinition, $table, $column);

        if ($this->getValue()) {
            $columnDefinition->default($this->getValue());
        } else {
            $timestamp = match ($this->type) {
                'time' => Carbon::now()->toTimeString(),
                'date' => Carbon::now()->toDateString(),
                'datetime' => Carbon::now()->toDateTimeString(),
            };

            $columnDefinition->default($timestamp);
        }
    }

    /**
     * @param bool $isEditing
     *
     * @inheritDoc
     */
    public function getFormComponent(bool $isEditing): ColComponent
    {
        return ColComponent::create()
            ->setMdCol(6)
            ->setComponent(
                CheckboxInputComponent::create()
                    ->setKey($this->getFormKey())
                    ->setLabel(trans('word.nullable'))
                    ->setVuexNamespace($this->getVuexNameSpace())
                    ->setHintIf(
                        $isEditing,
                        trans('text.time.not.null.use.now')
                    )
            );
    }
}
