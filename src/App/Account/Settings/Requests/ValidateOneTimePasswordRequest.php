<?php

namespace App\Account\Settings\Requests;

use Domain\Authentication\Rules\OneTimePasswordRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ValidateOneTimePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'one_time_password' => [
                'required',
                'digits:6',
                new OneTimePasswordRule(Auth::user(), true),
            ],
        ];
    }
}
