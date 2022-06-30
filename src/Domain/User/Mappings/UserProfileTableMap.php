<?php

    namespace Domain\User\Mappings;

    class UserProfileTableMap
    {
        public const TABLE = 'user_profiles';

        public const ID = 'id';
        public const USER_ID = 'user_id';
        public const FIRST_NAME = 'first_name';
        public const MIDDLE_NAME = 'middle_name';
        public const LAST_NAME = 'last_name';
        public const GENDER = 'gender';
        public const BIRTH_DATE = 'birth_date';
        public const PREFERENCES = 'preferences';
        public const CREATED_AT = 'created_at';
        public const UPDATED_AT = 'updated_at';

        public const TABLE_ID = 'user_profiles.id';
        public const TABLE_USER_ID = 'user_profiles.user_id';
        public const TABLE_FIRST_NAME = 'user_profiles.first_name';
        public const TABLE_MIDDLE_NAME = 'user_profiles.middle_name';
        public const TABLE_LAST_NAME = 'user_profiles.last_name';
        public const TABLE_GENDER = 'user_profiles.gender';
        public const TABLE_BIRTH_DATE = 'user_profiles.birth_date';
        public const TABLE_PREFERENCES = 'user_profiles.preferences';
        public const TABLE_CREATED_AT = 'user_profiles.created_at';
        public const TABLE_UPDATED_AT = 'user_profiles.updated_at';

        public const RELATIONSHIP_USER = 'user';
    }
