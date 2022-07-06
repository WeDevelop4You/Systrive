<?php

namespace Domain\Supervisor\Actions;

use Domain\Supervisor\DataTransferObjects\SupervisorProcessData;
use Domain\Supervisor\Models\Supervisor;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Support\Exceptions\ActionErrorException;
use Support\Exceptions\ShellCommandFailedException;
use Support\Services\ShellCommand;
use Support\Services\Supervisor as SupervisorService;

class SaveSupervisorProcessAction
{
    /**
     * SaveSupervisorProgressAction constructor.
     *
     * @param Supervisor|null $supervisor
     */
    public function __construct(
        private ?Supervisor $supervisor = null
    ) {
        //
    }

    /**
     * @param SupervisorProcessData $data
     *
     * @throws ActionErrorException
     * @throws Exception
     */
    public function __invoke(SupervisorProcessData $data): void
    {
        if (is_null($this->supervisor)) {
            $this->supervisor = new Supervisor();
            $this->supervisor->filename = Str::uuid();
        }

        $this->supervisor->name = $data->name;

        $rollback = $this->supervisor->config;

        SupervisorService::file()->put($this->supervisor->filename, $data->config);

        if (App::isProduction()) {
            try {
                $output = ShellCommand::execute('supervisorctl reread');

                if ($output->startsWith('ERROR: ')) {
                    throw new ShellCommandFailedException($output);
                }
            } catch (ShellCommandFailedException $e) {
                SupervisorService::file()->put($this->supervisor->filename, $rollback);

                throw new ActionErrorException($e->getMessage());
            }
        }

        (new ReloadSupervisorAction())();

        $this->supervisor->save();
    }
}
