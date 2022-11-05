<?php

    namespace Domain\Invite\DataTransferObject;

    use Illuminate\Support\Collection;

    final class CompanyInviteData
    {
        /**
         * @var Collection
         */
        public Collection $modules;

        /**
         * CompanyInviteData constructor.
         *
         * @param string $name
         * @param string $email
         * @param array  $modules
         */
        public function __construct(
            public string $name,
            public string $email,
            array $modules
        ) {
            $this->modules = Collection::make($modules);
        }
    }
