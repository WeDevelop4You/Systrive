<?php

    namespace Support\Helpers\Response\Action\Methods;

    use Support\Helpers\Response\Action\ActionMethodBase;

    class RequestMethod extends ActionMethodBase
    {
        /**
         * RequestMethod constructor.
         */
        public function __construct()
        {
            //
        }

        /**
         * @return RequestMethod
         */
        public static function create(): RequestMethod
        {
            return new static();
        }

        /**
         * @param string $url
         *
         * @return RequestMethod
         */
        public function get(string $url): RequestMethod
        {
            $this->content = [
                'method' => 'getRequestAction',
                'parameters' => [
                    $url,
                ],
            ];

            return $this;
        }
    }
