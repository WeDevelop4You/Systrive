<?php

    namespace Support\Helpers\Response\Action\Methods;

    use Support\Helpers\Response\Action\ActionMethodBase;

    class VuexMethod extends ActionMethodBase
    {
        /**
         * VuexMethod constructor.
         */
        public function __construct()
        {
            //
        }

        /**
         * @return VuexMethod
         */
        public static function create(): VuexMethod
        {
            return new static();
        }

        /**
         * @param string $type
         * @param mixed  $params
         *
         * @return VuexMethod
         */
        public function dispatch(string $type, mixed $params = null): VuexMethod
        {
            $this->content = [
                'method' => 'vuexDispatchMethod',
                'parameters' => [
                    $type,
                    $params,
                ],
            ];

            return $this;
        }
    }
