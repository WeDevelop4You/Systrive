<?php

    namespace Domain\Company\DataTransferObjects;

    final class CompleteCompanyData
    {
        public function __construct(
            public string $email,
            public ?string $domain = null,
            public ?string $information = null,
        ) {
            //
        }
    }
