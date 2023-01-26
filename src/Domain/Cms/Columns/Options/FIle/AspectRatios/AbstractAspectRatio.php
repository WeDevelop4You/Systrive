<?php

namespace Domain\Cms\Columns\Options\FIle\AspectRatios;

use Domain\Cms\Columns\Options\AbstractColumnOption;
use Illuminate\Foundation\Http\FormRequest;
use Support\Utils\Validations;

abstract class AbstractAspectRatio extends AbstractColumnOption
{
    protected function col(): int
    {
        return 6;
    }

    /**
     * @inheritDoc
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations(['required', 'integer', 'min:1']);
    }
}
