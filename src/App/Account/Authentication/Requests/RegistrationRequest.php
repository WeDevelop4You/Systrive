<?php

namespace App\Account\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'middle_name' => ['nullable', 'string'],
            'last_name' => ['required', 'string'],
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'birth_date' => ['required', 'string', 'date_format:Y-m-d'],
            'password' => ['required', Password::default()],
            'password_confirm' => ['required', 'same:password'],
            'accept' => ['required', 'accepted'],
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
