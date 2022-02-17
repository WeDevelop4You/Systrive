<?php

    namespace Support\Helpers;

    use Illuminate\Support\Facades\Crypt;
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
        private function createNewToken(): string
        {
            return hash_hmac('sha256', Str::random(40), Crypt::getKey());
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
            return Hash::make($this->getToken());
        }
    }
