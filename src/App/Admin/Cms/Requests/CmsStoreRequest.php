<?php

namespace App\Admin\Cms\Requests;

use Domain\Cms\Mappings\CmsTableMap;
use Domain\Company\Models\Company;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Support\Abstracts\AbstractRequest;

/**
 * @property Company          $company
 * @property array|int|string $username
 */
class CmsStoreRequest extends AbstractRequest
{
    protected function isUpdating(): bool
    {
        return \is_int($this->username);
    }

    protected function defaultRules(): array
    {
        return [
            'name' => ['required', 'string'],
            'database' => ['required', 'string', "max:{$this->max(64)}"],
        ];
    }

    protected function storeRules(): array
    {
        return [
            'username' => ['required', 'string', "max:{$this->max(32)}"],
            'password' => ['required', 'string', 'max:100'],
        ];
    }

    protected function updateRules(): array
    {
        return [
            'username' => Rule::exists('cms', CmsTableMap::COL_ID)->where(CmsTableMap::COL_COMPANY_ID, $this->company->id),
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

        return $total - $subtract;
    }
}
