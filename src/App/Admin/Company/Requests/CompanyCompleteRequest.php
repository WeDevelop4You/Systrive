<?php

    namespace App\Admin\Company\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class CompanyCompleteRequest extends FormRequest
    {
        /**
         * @return array
         */
        public function rules(): array
        {
            return [
                'email' => ['required', 'email'],
                'domain' => ['nullable', 'url'],
                'information' => ['nullable', 'string'],
            ];
        }
    }
