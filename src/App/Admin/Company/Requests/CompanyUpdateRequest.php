<?php

    namespace App\Admin\Company\Requests;

    use Domain\Company\Models\Company;
    use Illuminate\Support\Arr;
    use Illuminate\Validation\Rule;
    use Support\Abstracts\AbstractRequest;

    /**
     * @property Company          $company
     * @property array|int|string $owner
     */
    class CompanyUpdateRequest extends AbstractRequest
    {
        protected function isUpdating(): bool
        {
            return \is_int($this->owner);
        }

        protected function defaultRules(): array
        {
            return [
                'name' => ['required', Rule::unique('companies')->ignore($this->company)],
                'email' => ['required', 'email'],
                'domain' => ['nullable', 'url'],
                'owner' => ['required'],
                'modules' => ['required', 'array'],
                'remove_owner' => ['sometimes', 'boolean'],
            ];
        }

        protected function storeRules(): array
        {
            return [
                'owner' => ['email'],
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
