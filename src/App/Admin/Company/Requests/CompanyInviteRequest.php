<?php

namespace App\Admin\Company\Requests;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Support\Abstracts\AbstractRequest;

/**
 * @property array|int|string $owner
 */
class CompanyInviteRequest extends AbstractRequest
{
    protected function isUpdating(): bool
    {
        return \is_int($this->owner);
    }

    protected function defaultRules(): array
    {
        return [
            'owner' => ['required'],
            'name' => ['required', 'unique:companies,name'],
            'modules' => ['required', 'array'],
        ];
    }

    protected function storeRules(): array
    {
        return [
            'owner' => ['required', 'email'],
        ];
    }

    protected function updateRules(): array
    {
        return [
            'owner' => ['required', Rule::exists('users', 'id')],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'owner' => Arr::get($this->owner, 'value', fn () => $this->owner),
        ]);
    }
}
