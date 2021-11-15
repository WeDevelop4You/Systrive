<?php

    namespace App\Admin\Company\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class CompanyCreateRequest extends FormRequest
    {
        /**
         * @return array
         */
        public function rules(): array
        {
            return [
                'name' => ['required', 'unique:companies,name'],
                'owner_id' => ['required', 'exists:users,id'],
                'email' => ['required', 'email'],
                'domain' => ['nullable', 'url'],
            ];
        }
    }
