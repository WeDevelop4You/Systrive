<?php

    namespace App\Admin\Company\Requests;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    class CompanyCreateRequests extends FormRequest
    {
        /**
         * @return array
         */
        public function rules(): array
        {
            return [
                'name' => ['required'],
                'owner' => ['required', 'exists:users,id'],
                'email' => ['required', 'email'],
                'domain' => ['nullable', 'url'],
            ];
        }
    }
