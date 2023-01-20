<?php

namespace App\Admin\Supervisor\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupervisorProcessRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'config' => 'required|string',
        ];
    }
}
