<?php

    namespace Support\Enums;

    enum RequestMethodTypes: string
    {
        case GET = 'GET';
        case POST = 'POST';
        case PUT= 'PUT';
        case PATCH = 'PATCH';
        case DELETE = 'DELETE';
    }
