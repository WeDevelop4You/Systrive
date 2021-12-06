<?php

    namespace Domain\User\DataTransferObjects;

    final class UserProfileData
    {
        /**
         * UserProfileData constructor.
         *
         * @param string      $first_name
         * @param string      $last_name
         * @param string      $gender
         * @param string      $birth_date
         * @param string|null $middle_name
         * @param string|null $bio
         */
        public function __construct(
            public string $first_name,
            public string $last_name,
            public string $gender,
            public string $birth_date,
            public ?string $middle_name = null,
            public ?string $bio = null
        ) {
            //
        }
    }
