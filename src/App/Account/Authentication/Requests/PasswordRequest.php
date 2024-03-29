<?php

namespace App\Account\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
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
