<?php

namespace Support\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class FileExistRule implements Rule
{
    public function __construct(
        private readonly string $disk = 'tmp'
    ) {
        //
    }

    public function passes($attribute, $value): bool
    {
        return Storage::disk($this->disk)->exists($value);
    }

    public function message(): string
    {
        return trans('validation.file_exists');
    }
}