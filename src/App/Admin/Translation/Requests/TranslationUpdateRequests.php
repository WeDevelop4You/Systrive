<?php

    namespace App\Admin\Translation\Requests;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    class TranslationUpdateRequests extends FormRequest
    {
        /**
         * @return array
         */
        public function rules(): array
        {
            return [
                'translations.*.locale' => ['required', Rule::in(['en', 'nl'])],
                'translations.*.translation' => ['nullable', 'string']
            ];
        }
    }
