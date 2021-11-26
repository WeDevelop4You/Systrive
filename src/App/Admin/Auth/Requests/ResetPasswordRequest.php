<?php

namespace App\Admin\Auth\Requests;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', Password::default()],
            'password_confirm' => ['required', 'same:password']
        ];
    }

    /**
     * @return ResetPasswordRequest
     */
    public function prepareForValidation(): ResetPasswordRequest
    {
        try {
            $email = Crypt::decryptString($this->get('user_token', ''));
        } catch (DecryptException) {
            $email = '';
        }


        return $this->merge([
            'email' => $email
        ]);
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.email' => trans('passwords.token'),
            'email.required' => trans('passwords.token'),
            'password_confirm.same' => trans('validation.confirmed'),
        ];
    }
}
