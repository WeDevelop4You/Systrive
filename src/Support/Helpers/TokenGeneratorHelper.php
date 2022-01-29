<?php

    namespace Support\Helpers;

    use Illuminate\Encryption\MissingAppKeyException;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Str;

    class TokenGeneratorHelper
    {
        /**
         * @var string
         */
        private string $token;

        /**
         * TokenGeneratorHelper constructor.
         *
         * @param string|null $token
         */
        public function __construct(string $token = null)
        {
            $this->token = $token ?: $this->createNewToken();
        }

        /**
         * @param string|null $token
         *
         * @return static
         */
        public static function create(string $token = null): static
        {
            return new static($token);
        }

        /**
         * @return string
         */
        private function getHashKey(): string
        {
            $key = env('APP_KEY');

            if (Str::startsWith($key, 'base64:')) {
                return base64_decode(substr($key, 7));
            }

            throw new MissingAppKeyException();
        }

        /**
         * @return string
         */
        private function createNewToken(): string
        {
            return hash_hmac('sha256', Str::random(40), $this->getHashKey());
        }

        /**
         * @return string
         */
        public function getToken(): string
        {
            return $this->token;
        }

        /**
         * @return string
         */
        public function getHashToken(): string
        {
            return Hash::make($this->token);
        }
    }
