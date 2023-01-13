<?php

namespace App\Company\Cms\Requests;

use Domain\Cms\Columns\Attributes\CustomValidation;
use Domain\Cms\Models\CmsColumn;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property CmsColumn $column
 */
class CmsTableItemFileRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        $type = $this->column->type();

        if ($type instanceof CustomValidation) {
            return $type->getCustomValidation($this)->toArray('file');
        }

        return [];
    }
}
