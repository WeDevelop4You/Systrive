<?php

namespace Domain\Cms\Columns\Definitions;

use Illuminate\Foundation\Http\FormRequest;
use Support\Utils\Validations;

interface SubValidation
{
    /**
     * @param FormRequest $request
     *
     * @return Validations
     */
    public function getSubValidation(FormRequest $request): Validations;
}
