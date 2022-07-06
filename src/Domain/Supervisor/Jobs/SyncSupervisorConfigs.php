<?php

namespace Domain\Supervisor\Jobs;

use Domain\Supervisor\Models\Supervisor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Support\Services\Supervisor as SupervisorService;

;

class SyncSupervisorConfigs implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function uniqueId(): string
    {
        return "supervisor_configs";
    }

    public function handle(): void
    {
        $configs = SupervisorService::file()->allFiles();

        Supervisor::all()->each(function (Supervisor $supervisor) use (&$configs) {
            $config = array_search($supervisor->filename, $configs);

            if ($config !== false) {
                Arr::forget($configs, $config);
            } else {
                $supervisor->delete();
            }
        });

        Arr::map($configs, function ($file) use ($configs) {
            $uuid = Str::uuid();

            SupervisorService::file()->move($file, "{$uuid}.conf");

            $config = new Supervisor();
            $config->name = pathinfo($file, PATHINFO_FILENAME);
            $config->filename = $uuid;
            $config->save();
        });
    }
}
