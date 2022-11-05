<?php

namespace App\Admin\Cms\Requests;

use Domain\Cms\Mappings\CmsTableMap;
use Domain\Company\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

/**
 * @property Company $company
 */
class CmsStoreRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string'],
            'database' => ['required', 'string', "max:{$this->max(64)}"],
        ];

        if (\is_int($this->username)) {
            return [
                ...$rules,
                'username' => Rule::exists('cms', CmsTableMap::ID)
                    ->where(CmsTableMap::COMPANY_ID, $this->company->id),
            ];
        }

        return [
            ...$rules,
            'username' => ['required', 'string', "max:{$this->max(32)}"],
            'password' => ['required', 'string', 'max:100'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'username' => Arr::get($this->username, 'value', fn () => $this->username),
        ]);
    }

    private function max($total): int
    {
        $subtract = \strlen("{$this->company->system->username}_");

        return $total - $subtract ;
    }
}
