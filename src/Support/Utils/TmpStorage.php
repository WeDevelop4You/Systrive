<?php

namespace Support\Utils;

use Illuminate\Support\Facades\Storage as StorageBase;

class TmpStorage
{
    /**
     * @return static
     */
    public static function create(): static
    {
        return new static();
    }

    public function upload(string $identifier, string $directory = '')
    {
        $file = StorageBase::disk('tmp')->get($identifier);

        return StorageBase::put($directory, $file);
    }
}
