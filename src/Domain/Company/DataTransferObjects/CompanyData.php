<?php

    namespace Domain\Company\DataTransferObjects;

    final class CompanyData
    {
        /**
         * CompanyData constructor.
         *
         * @param string      $name
         * @param string      $email
         * @param string      $owner
         * @param string|null $domain
         * @param string|null $information
         */
        public function __construct(
            public string $name,
            public string $email,
            public string $owner,
            public ?string $domain = null,
            public ?string $information = null,
        ) {
        }
    }
