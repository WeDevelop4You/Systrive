<?php

    namespace App;

    use Illuminate\Foundation\Application as ApplicationBase;

    class Application extends ApplicationBase
    {
        protected $namespace = 'App\\';

        public function __construct($basePath = null)
        {
            parent::__construct($basePath);

            $this->useLangPath($this->langPath('backend'));
        }
    }
