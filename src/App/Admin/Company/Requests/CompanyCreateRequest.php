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
                'email' => ['required', 'email'],
                'modules' => ['required', 'array'],
            ];
        }

        protected function prepareForValidation()
        {
            $this->merge([
                'email' => $this?->owner,
            ]);
        }
    }
