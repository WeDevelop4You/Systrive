<?php

namespace App\Account\Settings\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::default()],
            'password_confirm' => ['required', 'same:password'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'password_confirm.same' => trans('validation.confirmed'),
        ];
    }
}
