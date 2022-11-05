<?php

namespace App\Admin\Account\Requests;

use Domain\Authentication\Rules\SecurityRule;
use Illuminate\Foundation\Http\FormRequest;

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
            'one_time_password' => ['bail', 'required', 'digits:6', new SecurityRule(true)],
        ];
    }
}
