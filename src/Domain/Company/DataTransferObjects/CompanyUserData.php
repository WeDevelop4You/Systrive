<?php

    namespace Domain\Company\DataTransferObjects;

    final class CompanyUserData
    {
        public function __construct(
            public array $roles,
            public array $permissions,
            public ?string $email = null
        ) {
            //
        }
    }
