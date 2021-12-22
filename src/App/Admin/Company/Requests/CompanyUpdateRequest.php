<?php

    namespace App\Admin\Company\Requests;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Validation\Rule;

    class CompanyUpdateRequest extends FormRequest
    {
        /**
         * @return array
         */
        public function rules(): array
        {
            return [
                'name' => [Rule::requiredIf(Auth::user()->hasRole('super_admin')), Rule::unique('companies')->ignore($this->company)],
                'owner_id' => ['required', 'exists:users,id'],
                'email' => ['required', 'email'],
                'domain' => ['nullable', 'url'],
                'information' => ['nullable', 'string'],
                'removeUser' => ['required', 'boolean'],
            ];
        }
    }
