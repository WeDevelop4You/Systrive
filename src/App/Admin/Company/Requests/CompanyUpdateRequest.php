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
            $ifSuperAdmin = Rule::requiredIf(Auth::user()->hasRole('super_admin'));

            return [
                'name' => [$ifSuperAdmin, Rule::unique('companies')->ignore($this->company)],
                'email' => ['required', 'email'],
                'domain' => ['nullable', 'url'],
                'information' => ['nullable', 'string'],
                'removeUser' => ['required', 'boolean'],
                'owner_email' => [$ifSuperAdmin, 'email'],
            ];
        }
    }
