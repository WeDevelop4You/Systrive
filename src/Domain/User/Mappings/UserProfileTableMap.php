<?php

namespace Domain\User\Mappings;

class UserProfileTableMap
{
    public const TABLE = 'user_profiles';
    public const COL_ID = 'id';
    public const COL_USER_ID = 'user_id';
    public const COL_FIRST_NAME = 'first_name';
    public const COL_MIDDLE_NAME = 'middle_name';
    public const COL_LAST_NAME = 'last_name';
    public const COL_GENDER = 'gender';
    public const COL_BIRTH_DATE = 'birth_date';
    public const COL_PREFERENCES = 'preferences';
    public const COL_CREATED_AT = 'created_at';
    public const COL_UPDATED_AT = 'updated_at';
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
    public const RELATION_USER = 'user';
}
