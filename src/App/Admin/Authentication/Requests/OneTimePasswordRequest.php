<?php

namespace App\Admin\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Support\Rules\OneTimePasswordRule;

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
