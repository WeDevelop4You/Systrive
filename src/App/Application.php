<?php

    namespace App;

    use Illuminate\Foundation\Application as ApplicationBase;

    class Application extends ApplicationBase
    {
        protected $namespace = 'App\\';

        protected $langPath = '../lang/backend';
    }
