<?php

namespace App\Console\Commands;

use Domain\Cms\Models\Cms;
use Illuminate\Console\Command;
use Support\Services\Cms as CmsService;

class CmsMigrateCommand extends Command
{
    protected $signature = 'cms:migrate {cms? : cms database name}';

    protected $description = 'run a migrate on all the cms databases';

    public function handle(): bool
    {
        $database = $this->argument('cms');

        if (!\is_null($database)) {
            $cms = Cms::whereDatabase($database)->first();

            if ($cms instanceof Cms) {
                $this->migrate($cms);
            } else {
                $this->error('Unknown cms database');
            }
        } else {
            Cms::all()->each(function (Cms $cms) {
                $this->migrate($cms);
            });
        }

        return true;
    }

    private function migrate(Cms $cms)
    {
        $this->info("Database: {$cms->database}");

        CmsService::createConnection($cms);

        $this->call('migrate', [
            '--database' => 'cms',
            '--path' => 'src/Domain/CMS/Migrations',
        ]);
    }
}
