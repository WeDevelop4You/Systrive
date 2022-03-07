<?php

    namespace Support\Enums;

    enum VestaCommands: string
    {
        case GET_USERS = 'v-list-users';
        case GET_SYSTEM_USERS = 'v-list-sys-users';
        case GET_USER_DOMAIN = 'v-list-web-domain';
        case GET_USER_DOMAINS = 'v-list-web-domains';
        case GET_USER_DATABASES = 'v-list-databases';
        case GET_USER_DNS_DOMAIN = 'v-list-dns-domain';
        case GET_USER_DNS_RECORDS = 'v-list-dns-records';
        case GET_USER_DNS_DOMAINS = 'v-list-dns-domains';
        case GET_USER_MAIL_DOMAINS = 'v-list-mail-domains';
        case GET_USER_MAIL_ADDRESSES = 'v-list-mail-accounts';

        case TEST = '';
    }
