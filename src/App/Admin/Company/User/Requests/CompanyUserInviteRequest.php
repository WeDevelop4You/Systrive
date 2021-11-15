<?php

    namespace App\Admin\Company\User\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class CompanyUserInviteRequest extends FormRequest
    {
        /**
         * @return array
         */
        public function rules(): array
        {
            return [
                'email' => ['required', 'email'],
                'roles' => ['present', 'array'],
                'roles.*' => ['exists:roles,id'],
                'permissions' => ['present', 'array'],
                'permissions.*' => ['exists:permissions,id']
            ];
        }
    }
