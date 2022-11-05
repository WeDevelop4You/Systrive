<?php

namespace Domain\Cms\DataTransferObjects;

use Domain\Cms\Models\Cms;

final class CmsData
{
    public function __construct(
        public string $name,
        public string $database,
        public int|string $username,
        public ?string $password = null,
    ) {
        if (\is_int($username)) {
            $cms = Cms::find($username);

            if ($cms instanceof Cms) {
                $this->username = $cms->username->decryptString();
                $this->password = $cms->password->decryptString();
            }
        }
    }
}
