<?php

namespace Domain\Cms\Columns\Definitions;

use Illuminate\Foundation\Http\FormRequest;
use Support\Utils\Validations;

interface Validation
{
    /**
     * validation for creating and editing item.
     *
     * @param FormRequest $request
     *
     * @return Validations
     */
    public function getValidation(FormRequest $request): Validations;
}
