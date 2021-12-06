<?php

namespace App\Admin\Auth\Requests;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
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
