<?php

namespace Domain\Cms\Columns\Attributes;

use Illuminate\Foundation\Http\FormRequest;
use Support\Utils\Validations;

interface CustomValidation
{
    /**
     * @param FormRequest $request
     *
     * @return Validations
     */
    public function getCustomValidation(FormRequest $request): Validations;
}
