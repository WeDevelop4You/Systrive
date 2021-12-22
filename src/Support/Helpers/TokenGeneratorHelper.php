<?php

    namespace Support\Helpers;

    use Illuminate\Encryption\MissingAppKeyException;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Str;

    class TokenGeneratorHelper
    {
        private string $token;

        /**
         * TokenGeneratorHelper constructor.
         */
        public function __construct()
        {
            $this->createNewToken();
        }

        /**
         * @return static
         */
        public static function create(): static
        {
            return new static;
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

        private function createNewToken(): void
        {
            $this->token = hash_hmac('sha256', Str::random(40), $this->getHashKey());
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
