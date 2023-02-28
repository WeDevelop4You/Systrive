<?php

namespace App\Company\Cms\Requests;

use Domain\Cms\Columns\Definitions\SubValidation;
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

        if ($type instanceof SubValidation) {
            return $type->getSubValidation($this)->toArray('file');
        }

        return [];
    }
}
