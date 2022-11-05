<?php

namespace Support\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Support\Exceptions\Custom\ShellCommandFailedException;
use Symfony\Component\Process\Process;

class ShellCommand
{
    /**
     * @param $cmd
     *
     * @throws ShellCommandFailedException
     *
     * @return Stringable
     */
    public static function execute($cmd): Stringable
    {
        $process = Process::fromShellCommandline($cmd);

        $processOutput = '';

        $captureOutput = function ($type, $line) use (&$processOutput) {
            $processOutput .= $line;
        };

        $process->setTimeout(null)
            ->run($captureOutput);

        if ($process->getExitCode()) {
            throw new ShellCommandFailedException($processOutput);
        }

        return Str::of($processOutput);
    }
}
