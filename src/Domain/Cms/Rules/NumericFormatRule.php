<?php

namespace Domain\Cms\Rules;

use Illuminate\Contracts\Validation\Rule;

class NumericFormatRule implements Rule
{
    public function __construct(
        private readonly int $total,
        private readonly int $places,
    ) {
        //
    }

    /**
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!$this->places) {
            return \strlen($value) <= $this->total;
        }

        return preg_match(
            "/[0-9]{1,{$this->total}}(.[0-9]{1,{$this->places}})?$/",
            $value
        );
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return trans('validation.format.number');
    }
}
