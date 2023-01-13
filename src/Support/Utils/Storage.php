<?php

namespace Support\Utils;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage as StorageBase;

class Storage
{
    private function __construct()
    {
    }

    /**
     * @return static
     */
    public static function create(): static
    {
        return new static();
    }

    /**
     * @param File|string|UploadedFile $file
     *
     * @return false|string
     */
    public function preUpload(File|UploadedFile|string $file): string|bool
    {
        return StorageBase::disk('tmp')->putFile('', $file);
    }

    public function upload()
    {
    }

    public function uploadTmp()
    {
    }
}
