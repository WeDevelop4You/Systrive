<?php

    namespace Domain\Company\DataTransferObjects;

    use Illuminate\Support\Collection;

    final class CompanyData
    {
        /**
         * @var Collection
         */
        public Collection $modules;

        /**
         * CompanyData constructor.
         *
         * @param string      $name
         * @param string      $email
         * @param string      $owner
         * @param array       $modules
         * @param string|null $domain
         * @param string|null $information
         */
        public function __construct(
            public string $name,
            public string $email,
            public string $owner,
            array $modules,
            public ?string $domain = null,
            public ?string $information = null,
        ) {
            $this->modules = Collection::make($modules);
        }
    }
