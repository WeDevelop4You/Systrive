<?php

namespace Support\Services;

use Supervisor\Api;

class Supervisor
{
    /**
     * @var Api
     */
    private Api $api;

    /**
     * Supervisor constructor.
     */
    private function __construct()
    {
        $this->api = new Api(
            config('services.supervisor.url'),
            config('services.supervisor.post'),
            config('services.supervisor.username'),
            config('services.supervisor.password'),
        );
    }

    /**
     * @return Api
     */
    public static function api(): Api
    {
        $instance = new static();

        return $instance->api;
    }

    /**
     * @param int $state
     *
     * @return bool
     */
    public static function inProcessRunning(int $state): bool
    {
        return in_array($state, [10, 20, 30]);
    }

    /**
     * @param int $state
     *
     * @return string
     */
    public static function getProcessState(int $state): string
    {
        return match ($state) {
            0 => trans('word.stopped'),
            10 => trans('word.starting'),
            20 => trans('word.running'),
            30 => trans('word.backoff'),
            40 => trans('word.stopping'),
            100 => trans('word.exited'),
            200 => trans('word.fatal'),
            1000 => trans('word.unknown'),
        };
    }
}
