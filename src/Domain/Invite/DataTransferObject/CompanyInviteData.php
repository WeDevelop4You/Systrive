<?php

    namespace Domain\Invite\DataTransferObject;

    class CompanyInviteData
    {
        public function __construct(
            public string $name,
            public string $email
        ) {
            //
        }
    }
