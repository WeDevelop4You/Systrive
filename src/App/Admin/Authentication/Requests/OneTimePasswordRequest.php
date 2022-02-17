<?php

namespace App\Admin\Authentication\Requests;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rules\Password;
use Support\Rules\OneTimePasswordRule;
use function trans;

class OneTimePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'one_time_password' => ['bail', 'required', 'digits:6', new OneTimePasswordRule(true)],
        ];
    }
}
