<?php

namespace App\Company\Cms\Requests;

use Domain\Cms\Models\CmsTable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property CmsTable $table
 */
class CmsTableItemFileRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'key' => ['required', Rule::in([])],
            'file' => '',
        ];
    }
}
