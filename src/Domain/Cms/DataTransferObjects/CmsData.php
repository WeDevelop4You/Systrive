<?php

namespace Domain\Cms\DataTransferObjects;

use Domain\Cms\Models\Cms;

final class CmsData
{
    /**
     * @var string
     */
    public readonly string $username;

    /**
     * @var string
     */
    public readonly string $password;

    /**
     * CmsData constructor.
     *
     * @param string      $name
     * @param string      $database
     * @param int|string  $username
     * @param string|null $password
     */
    public function __construct(
        public readonly string $name,
        public readonly string $database,
        string|int $username,
        string|null $password = null,
    ) {
        if (\is_int($username)) {
            $cms = Cms::find($username);

            $this->username = $cms->username->decrypt;
            $this->password = $cms->password->decrypt;
        } else {
            $this->username = $username;
            $this->password = $password;
        }
    }
}
