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

class ArrayMustContainRule implements Rule
{
    public function __construct(
        private readonly array $items,
        private readonly ?string $key = null
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
        if ($this->key) {
            $value = Arr::pluck($value, $this->key);
        }

        foreach ($this->items as $item) {
            if (!in_array($item, $value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return Application|array|string|Translator|null
     */
    public function message(): array|string|Translator|Application|null
    {
        return trans('validation.array.missing.value');
    }
}
