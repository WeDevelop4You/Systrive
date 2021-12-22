<?php

    namespace Domain\Company\DataTransferObjects;

    final class CompanyData
    {
        /**
         * CompanyData constructor.
         *
         * @param string      $name
         * @param string      $email
         * @param int|null    $owner_id
         * @param string|null $domain
         * @param string|null $information
         */
        public function __construct(
            public string $name,
            public string $email,
            public ?int $owner_id = null,
            public ?string $domain = null,
            public ?string $information = null,
        ) {
            //
        }
    }
