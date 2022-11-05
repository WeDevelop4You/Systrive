<?php

namespace Domain\Cms\Rules;

use Domain\User\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Support\Helpers\SecurityHelper;

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
            return strlen($value) <= $this->total;
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

