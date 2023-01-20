<?php

namespace Domain\Company\DataTransferObjects;

use Domain\User\Actions\CreateUserAction;
use Domain\User\Models\User;

/**
 * @property User $user
 */
final class CompanyUserData
{
    private User $user;

    public function __construct(
        public readonly array $roles,
        public readonly array $permissions,
        private readonly ?string $email = null
    ) {
        //
    }

    /**
     * @param User $user
     *
     * @return CompanyUserData
     */
    public static function createForUser(User $user): CompanyUserData
    {
        $instance = new self([], []);
        $instance->setUser($user);

        return $instance;
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    private function getUser(): User
    {
        if (! isset($this->user)) {
            $this->user = User::withTrashed()
                ->whereEmail($this->email)
                ->firstOr(fn (): User => (new CreateUserAction())($this->email));
        }

        return $this->user;
    }

    /**
     * @param string $name
     *
     * @return User
     */
    public function __get(string $name)
    {
        return match ($name) {
            'user' => $this->getUser(),
        };
    }
}
