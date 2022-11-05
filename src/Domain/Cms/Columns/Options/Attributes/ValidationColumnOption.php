<?php

namespace Domain\Cms\Columns\Options\Attributes;

use Illuminate\Foundation\Http\FormRequest;

interface ValidationColumnOption
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isDirty(mixed $value): bool;

    /**
     * validation for creating and editing item.
     *
     * @return object|string|string[]
     */
    public function getValidation(FormRequest $request): array|string|object;
}
