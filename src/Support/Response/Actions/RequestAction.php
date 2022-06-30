<?php

    namespace Support\Response\Actions;

    use Support\Enums\RequestMethodTypes;
    use Support\Enums\SessionKeyTypes;

    class RequestAction extends AbstractAction
    {
        public function __construct()
        {
            $this->setMethod('actionRequest');
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
                'method' => RequestMethodTypes::GET->value,
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
                'method' => RequestMethodTypes::POST->value,
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
                'method' => RequestMethodTypes::PATCH->value,
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
                'method' => RequestMethodTypes::DELETE->value,
            ]);
        }

        /**
         * @param SessionKeyTypes $key
         *
         * @return RequestAction
         */
        public function forgetSessionKey(SessionKeyTypes $key = SessionKeyTypes::KEEP): RequestAction
        {
            return $this->delete(
                route('admin.session.delete', [
                    'key' => $key->value,
                ])
            );
        }
    }
