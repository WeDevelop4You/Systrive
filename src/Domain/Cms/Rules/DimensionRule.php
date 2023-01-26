<?php

namespace Domain\Cms\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class DimensionRule implements DataAwareRule, Rule
{
    /**
     * All of the data under validation.
     *
     * @var array
     */
    protected array $data;

    /**
     * DimensionRule constructor
     *
     * @param string $otherDimensionKey
     * @param string $aspectRatioWidthKey
     * @param string $aspectRatioHeightKey
     * @param bool   $isWidth
     */
    public function __construct(
        private readonly string $otherDimensionKey,
        private readonly string $aspectRatioWidthKey,
        private readonly string $aspectRatioHeightKey,
        private readonly bool $isWidth = false
    ) {

    }

    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data): static
    {
        $this->data = $data;

        return $this;
    }

    public function passes($attribute, $value): bool
    {
        $otherDimension = (int) Arr::get($this->data, $this->otherDimensionKey);
        $aspectRadioWidth = (int) Arr::get($this->data, $this->aspectRatioWidthKey);
        $aspectRadioHeight = (int) Arr::get($this->data, $this->aspectRatioHeightKey);

        if ($this->isWidth) {
            return (int) $value === (int) round($otherDimension * ($aspectRadioWidth / $aspectRadioHeight));
        }

        return (int) $value === (int) round($otherDimension * ($aspectRadioHeight / $aspectRadioWidth));
    }

    public function message(): string
    {
        return trans('validation.dimension_aspect_radio');
    }
}
