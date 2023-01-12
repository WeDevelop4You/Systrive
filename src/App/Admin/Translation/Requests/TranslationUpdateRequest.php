<?php

namespace App\Admin\Translation\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;

class TranslationUpdateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'translations.*.locale' => ['required', Rule::in(Config::get('translations.locale', []))],
            'translations.*.translation' => ['nullable', 'string'],
        ];
    }
}
