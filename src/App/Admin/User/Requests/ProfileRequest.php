<?php

namespace App\Admin\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'first_name' => ucfirst(strtolower($this->first_name)),
            'middle_name' => strtolower($this->first_name),
            'last_name' => ucfirst(strtolower($this->last_name)),
        ]);
    }
}
