<?php

    namespace Support\Services;

    use CurlHandle;
    use Illuminate\Support\Collection;
    use Support\Enums\VestaCommands;
    use Support\Exceptions\UnknownResponseCodeException;
    use Support\Exceptions\VestaCommandException;
    use Support\Exceptions\VestaCredentialsNotSetException;

    class Vesta
    {
        public const SUCCESS = 0;
        public const ERROR_ARGS = 1;
        public const ERROR_INVALID = 2;
        public const ERROR_NOT_EXIST = 3;
        public const ERROR_EXISTS = 4;
        public const ERROR_SUSPENDED = 5;
        public const ERROR_UNSUSPENDED = 6;
        public const ERROR_INUSE = 7;
        public const ERROR_LIMIT = 8;
        public const ERROR_PASSWORD = 9;
        public const ERROR_FORBIDDEN = 10;
        public const ERROR_DISABLED = 11;
        public const ERROR_PARSING = 12;
        public const ERROR_DISK = 13;
        public const ERROR_LA = 14;
        public const ERROR_CONNECT = 15;
        public const ERROR_FTP = 16;
        public const ERROR_DB = 17;
        public const ERROR_RRD = 18;
        public const ERROR_UPDATE = 19;
        public const ERROR_RESTART = 20;

        /**
         * @var CurlHandle
         */
        private CurlHandle $curl;

        /**
         * VestaAPIHelper constructor.
         *
         * @throws VestaCredentialsNotSetException
         */
        private function __construct()
        {
            $this->checkCredentials();
            $this->initialize();
        }

        /**
         * @return Vesta
         */
        public static function api(): Vesta
        {
            return new static();
        }

        /**
         * @param VestaCommands $command
         * @param array         $parameters
         *
         * @return Collection
         */
        public function get(VestaCommands $command, ...$parameters): Collection
        {
            $parameters = [...$parameters, 'json'];

            $this->createRequestData($command->value, $parameters);

            $data = json_decode($this->execute(), true);

            return Collection::make($data);
        }

        /**
         * @param string $command
         * @param array  $parameters
         *
         * @throws VestaCommandException
         *
         * @return bool
         */
        public function post(string $command, ...$parameters): bool
        {
            $parameters = ['returncode' => 'yes', ...$parameters];

            $this->createRequestData($command, $parameters);

            $response = (int) $this->execute();

            if (!$response) {
                return true;
            }

            throw new VestaCommandException('Something went wrong executing the command', $response);
        }

        /**
         * @throws VestaCredentialsNotSetException
         */
        private function checkCredentials(): void
        {
            if (\is_null(config('services.vesta.hostname')) ||
                \is_null(config('services.vesta.username')) ||
                \is_null(config('services.vesta.password'))
            ) {
                throw new VestaCredentialsNotSetException('Not all credentials are set for vesta api');
            }
        }

        private function initialize(): void
        {
            $hostname = config('services.vesta.hostname');

            $url = "https://{$hostname}:8083/api/";

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_POST, true);

            $this->curl = $curl;
        }

        private function createRequestData(string $command, array $parameters): void
        {
            $number = 1;
            $data = [
                'user' => config('services.vesta.username'),
                'password' => config('services.vesta.password'),
                'cmd' => $command,
            ];

            foreach ($parameters as $index => $value) {
                if (\is_string($index)) {
                    $data[$index] = $value;
                } else {
                    $data["arg{$number}"] = $value;
                    $number++;
                }
            }

            $queryData = http_build_query($data);

            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $queryData);
        }

        /**
         * @return bool|string
         */
        private function execute(): bool|string
        {
            return curl_exec($this->curl);
        }

        /**
         * @param int $code
         *
         * @throws UnknownResponseCodeException
         *
         * @return string
         */
        public static function getResponseCodeTranslation(int $code): string
        {
            return match ($code) {
                self::SUCCESS => trans('response.success.vesta.api.success'),
                self::ERROR_ARGS => trans('response.error.vesta.api.args'),
                self::ERROR_INVALID => trans('response.error.vesta.api.invalid'),
                self::ERROR_NOT_EXIST => trans('response.error.vesta.api.not_exist'),
                self::ERROR_EXISTS => trans('response.error.vesta.api.exists'),
                self::ERROR_SUSPENDED => trans('response.error.vesta.api.suspended'),
                self::ERROR_UNSUSPENDED => trans('response.error.vesta.api.unsuspended'),
                self::ERROR_INUSE => trans('response.error.vesta.api.inuse'),
                self::ERROR_LIMIT => trans('response.error.vesta.api.limit'),
                self::ERROR_PASSWORD => trans('response.error.vesta.api.password'),
                self::ERROR_FORBIDDEN => trans('response.error.vesta.api.forbidden'),
                self::ERROR_DISABLED => trans('response.error.vesta.api.disabled'),
                self::ERROR_PARSING => trans('response.error.vesta.api.parsing'),
                self::ERROR_DISK => trans('response.error.vesta.api.disk'),
                self::ERROR_LA => trans('response.error.vesta.api.la'),
                self::ERROR_CONNECT => trans('response.error.vesta.api.connect'),
                self::ERROR_FTP => trans('response.error.vesta.api.ftp'),
                self::ERROR_DB => trans('response.error.vesta.api.db'),
                self::ERROR_RRD => trans('response.error.vesta.api.rrd'),
                self::ERROR_UPDATE => trans('response.error.vesta.api.update'),
                self::ERROR_RESTART => trans('response.error.vesta.api.restart'),
                default => throw new UnknownResponseCodeException(),
            };
        }
    }