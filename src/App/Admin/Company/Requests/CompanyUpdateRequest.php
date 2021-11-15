<?php

    namespace App\Admin\Company\Requests;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    class CompanyUpdateRequest extends FormRequest
    {
        /**
         * @return array
         */
        public function rules(): array
        {
            return [
                'name' => ['required', Rule::unique('companies')->ignore($this->company)],
                'owner' => ['required', 'exists:users,id'],
                'email' => ['required', 'email'],
                'domain' => ['nullable', 'url'],
                'removeUser' => ['required', 'boolean'],
            ];
        }
    }
