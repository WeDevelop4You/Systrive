<?php

    namespace App\Admin\Company\User\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class CompanyUserUpdateRequest extends FormRequest
    {
        /**
         * @return array
         */
        public function rules(): array
        {
            return [
                'roles' => ['present', 'array'],
                'roles.*' => ['exists:roles,id'],
                'permissions' => ['present', 'array'],
                'permissions.*' => ['exists:permissions,id'],
            ];
        }
    }
