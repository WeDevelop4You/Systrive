<?php

    namespace Support\Helpers\Response\Action\Methods;

    use Support\Abstracts\Response\AbstractAction;
    use Support\Enums\RequestMethodTypes;

    class RequestMethods extends AbstractAction
    {
        public function __construct()
        {
            $this->setMethod('actionRequest');
        }

        /**
         * @param string $url
         *
         * @return RequestMethods
         */
        public function get(string $url): RequestMethods
        {
            return $this->setData([
                'url' => $url,
                'params' => [],
                'method' => RequestMethodTypes::GET->value,
            ]);
        }

        /**
         * @param string $url
         * @param array  $params
         *
         * @return RequestMethods
         */
        public function post(string $url, array $params = []): RequestMethods
        {
            return $this->setData([
                'url' => $url,
                'params' => $params,
                'method' => RequestMethodTypes::POST->value,
            ]);
        }

        /**
         * @param string $url
         * @param array  $params
         *
         * @return RequestMethods
         */
        public function patch(string $url, array $params = []): RequestMethods
        {
            return $this->setData([
                'url' => $url,
                'params' => $params,
                'method' => RequestMethodTypes::PATCH->value,
            ]);
        }

        /**
         * @param string $url
         *
         * @return RequestMethods
         */
        public function delete(string $url): RequestMethods
        {
            return $this->setData([
                'url' => $url,
                'params' => [],
                'method' => RequestMethodTypes::DELETE->value,
            ]);
        }
    }
