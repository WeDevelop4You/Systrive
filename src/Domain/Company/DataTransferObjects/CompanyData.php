<?php

    namespace Domain\Company\DataTransferObjects;

    final class CompanyData
    {
        /**
         * @var int|null
         */
        public ?int $owner_id = null;

        /**
         * @var string|null
         */
        public ?string $owner_email = null;

        /**
         * CompanyData constructor.
         *
         * @param string      $name
         * @param string      $email
         * @param array|null  $owner
         * @param string|null $domain
         * @param string|null $information
         */
        public function __construct(
            public string $name,
            public string $email,
            public ?string $domain = null,
            public ?string $information = null,
            ?array $owner = null,
        ) {
            if (!is_null($owner)) {
                $this->owner_id = $owner['id'];
                $this->owner_email = $owner['email'];
            }
        }
    }
