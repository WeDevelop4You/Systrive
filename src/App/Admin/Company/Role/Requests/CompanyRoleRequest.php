<?php

    namespace App\Admin\Company\Role\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class CompanyRoleRequest extends FormRequest
    {
        /**
         * @return array
         */
        public function rules(): array
        {
            return [
                'name' => ['required', 'string', 'min:2'],
                'permissions' => ['required', 'array', 'min:1'],
                'permissions.*' => ['exists:permissions,id'],
            ];
        }

        /**
         * @return array
         */
        public function messages(): array
        {
            return [
                'permissions.required' => trans('Validation.custom.translation.required'),
            ];
        }
    }
