<?php

    namespace Support\Response\Actions;

    use Support\Enums\RequestMethodType;
    use Support\Enums\SessionKeyType;

    class RequestAction extends AbstractAction
    {
        public function __construct()
        {
            $this->setMethod('requestAction');
        }

        /**
         * @param string $url
         *
         * @return RequestAction
         */
        public function get(string $url): RequestAction
        {
            return $this->setData([
                'url' => $url,
                'params' => [],
                'method' => RequestMethodType::GET->value,
            ]);
        }

        /**
         * @param string $url
         * @param array  $params
         *
         * @return RequestAction
         */
        public function post(string $url, array $params = []): RequestAction
        {
            return $this->setData([
                'url' => $url,
                'params' => $params,
                'method' => RequestMethodType::PATCH->value,
            ]);
        }

        /**
         * @param string $url
         *
         * @return RequestAction
         */
        public function put(string $url): RequestAction
        {
            return $this->setData([
                'url' => $url,
                'params' => [],
                'method' => RequestMethodType::PUT->value,
            ]);
        }

        /**
         * @param string $url
         * @param array  $params
         *
         * @return RequestAction
         */
        public function patch(string $url, array $params = []): RequestAction
        {
            return $this->setData([
                'url' => $url,
                'params' => $params,
                'method' => RequestMethodType::PATCH->value,
            ]);
        }

        /**
         * @param string $url
         *
         * @return RequestAction
         */
        public function delete(string $url): RequestAction
        {
            return $this->setData([
                'url' => $url,
                'params' => [],
                'method' => RequestMethodType::DELETE->value,
            ]);
        }

        /**
         * @param SessionKeyType $key
         *
         * @return RequestAction
         */
        public function forgetSessionKey(SessionKeyType $key = SessionKeyType::KEEP): RequestAction
        {
            return $this->delete(
                route('admin.session.delete', [
                    'key' => $key->value,
                ])
            );
        }
    }
