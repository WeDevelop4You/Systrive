<?php

namespace App\Company\Cms\Requests;

use Domain\Cms\Models\CmsTable;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property CmsTable $table
 */
class CmsTableItemRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return $this->table->formColumns->createFormRules($this)->toArray();
    }
}
