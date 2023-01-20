<?php

namespace Support\Services;

use CurlHandle;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Support\Enums\VestaCommand;
use Support\Exceptions\Custom\UnknownResponseCodeException;
use Support\Exceptions\Custom\Vesta\VestaCommandException;
use Support\Exceptions\Custom\Vesta\VestaConnectionFailedException;
use Support\Exceptions\Custom\Vesta\VestaCredentialsNotSetException;

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
        if (\is_null(config('services.vesta.hostname')) ||
            \is_null(config('services.vesta.username')) ||
            \is_null(config('services.vesta.password'))
        ) {
            throw new VestaCredentialsNotSetException('Not all credentials are set for vesta api');
        }

        $hostname = config('services.vesta.hostname');

        $curl = curl_init("https://{$hostname}:8083/api/");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST, true);

        $this->curl = $curl;
    }

    /**
     * @return Vesta
     */
    public static function api(): Vesta
    {
        return new static();
    }

    /**
     * @param VestaCommand $command
     * @param array        $parameters
     *
     * @return Collection
     *
     * @throws VestaConnectionFailedException
     */
    public function get(VestaCommand $command, ...$parameters): Collection
    {
        $parameters = [...$parameters, 'json'];

        $this->setData($command->value, $parameters);

        return Collection::json($this->execute());
    }

    /**
     * @param VestaCommand $command
     * @param array        $parameters
     *
     * @return bool
     *
     * @throws VestaCommandException
     * @throws VestaConnectionFailedException
     */
    public function post(VestaCommand $command, ...$parameters): bool
    {
        $parameters = ['returncode' => 'yes', ...Arr::flatten($parameters)];

        $this->setData($command->value, $parameters);

        $response = (int) $this->execute();

        if ($response === self::SUCCESS) {
            return true;
        }

        throw new VestaCommandException('Something went wrong executing the command', $response);
    }

    private function setData(string $command, array $parameters): void
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
     *
     * @throws VestaConnectionFailedException
     */
    private function execute(): bool|string
    {
        $data = curl_exec($this->curl);
        $error = curl_error($this->curl);

        curl_close($this->curl);

        if ($data === false) {
            throw new VestaConnectionFailedException($error);
        }

        return $data;
    }

    /**
     * @param int $code
     *
     * @return string
     *
     * @throws UnknownResponseCodeException
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
