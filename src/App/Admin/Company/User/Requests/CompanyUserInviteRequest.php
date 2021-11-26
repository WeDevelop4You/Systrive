<?php

    namespace App\Admin\Company\User\Requests;

    use Domain\User\Models\User;
    use Illuminate\Foundation\Http\FormRequest;
    use Support\Rules\BelongsToManyExistsRule;

    class CompanyUserInviteRequest extends FormRequest
    {
        /**
         * @return array
         */
        public function rules(): array
        {
            return [
                'email' => ['required', 'email', new BelongsToManyExistsRule(
                    User::query(),
                    $this->company->users(),
                    'user_id',
                    null,
                    false
                )],
                'roles' => ['present', 'array'],
                'roles.*' => ['exists:roles,id'],
                'permissions' => ['present', 'array'],
                'permissions.*' => ['exists:permissions,id'],
            ];
        }
    }
