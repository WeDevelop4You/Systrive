<?php

namespace App\Admin\Cms\Requests;

use Domain\Cms\Enums\CmsColumnType;
use Domain\Cms\Helpers\CmsTableHelper;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

/**
 * @property string $key
 */
class CmsTableColumnRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        $optionRules = CmsTableHelper::getFormRules($this);
        $keys = array_map('strtolower', $this->keys ?? []);

        return [
            CmsColumnTableMap::KEY => ['required', 'string', 'alpha_dash', 'max:64', Rule::notIn($keys)],
            CmsColumnTableMap::TYPE => ['required', Rule::notIn(CmsColumnType::getHiddenValues()), new Enum(CmsColumnType::class)],
            CmsColumnTableMap::LABEL => ['required', 'string'],
            CmsColumnTableMap::EDITABLE => ['required', 'boolean'],
            CmsColumnTableMap::PROPERTIES => ['present', 'array'],
            ...$optionRules,
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            CmsColumnTableMap::KEY => strtolower($this->key),
            CmsColumnTableMap::EDITABLE => $this->editable ?? false,
        ]);
    }
}
