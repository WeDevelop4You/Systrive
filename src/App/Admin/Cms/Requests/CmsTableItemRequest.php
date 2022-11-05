<?php

namespace App\Admin\Cms\Requests;

use Domain\Cms\Helpers\CmsTableHelper;
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
        return CmsTableHelper::create($this->table)->getRules($this);
    }
}
