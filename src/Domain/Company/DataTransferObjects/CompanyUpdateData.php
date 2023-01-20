<?php

namespace Domain\Company\DataTransferObjects;

use Domain\User\Actions\CreateUserAction;
use Domain\User\Models\User;
use Illuminate\Support\Collection;

/**
 * @property User       $owner
 * @property Collection $modules
 */
final class CompanyUpdateData
{
    /**
     * CompanyData constructor.
     *
     * @param string      $name
     * @param string      $email
     * @param int|string  $owner
     * @param array       $modules
     * @param string|null $domain
     */
    public function __construct(
            public readonly string $name,
            public readonly string $email,
            private readonly string|int $owner,
            private readonly array $modules,
            public readonly ?string $domain = null,
        ) {
            //
    }

    public function __get(string $name)
    {
        return match ($name) {
            'modules' => Collection::make($this->modules),
            'owner' => \is_int($this->owner) ? User::find($this->owner) : (new CreateUserAction())($this->owner)
        };
    }
}
