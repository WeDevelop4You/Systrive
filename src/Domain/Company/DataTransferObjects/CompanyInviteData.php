<?php

namespace Domain\Company\DataTransferObjects;

use Domain\User\Actions\CreateUserAction;
use Domain\User\Models\User;
use Illuminate\Support\Collection;

/**
 * @property User       $owner
 * @property Collection $modules
 */
final class CompanyInviteData
{
    private User $user;

    /**
     * CompanyCreateData constructor.
     *
     * @param string     $name
     * @param int|string $owner
     * @param array      $modules
     */
    public function __construct(
        public readonly string $name,
        private readonly string|int $owner,
        private readonly array $modules
    ) {
        //
    }

    /**
     * @return User
     */
    private function getUser(): User
    {
        if (!isset($this->user)) {
            $this->user = \is_int($this->owner)
                ? User::find($this->owner)
                : (new CreateUserAction())($this->owner);
        }

        return $this->user;
    }

    /**
     * @param string $name
     *
     * @return Collection|User
     */
    public function __get(string $name)
    {
        return match ($name) {
            'owner' => $this->getUser(),
            'modules' => Collection::make($this->modules),
        };
    }
}
