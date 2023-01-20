<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Finder;

class StorageClearCommand extends Command
{
    protected $signature = 'storage:clear-tmp';

    protected $description = 'deletes all the files in tmp';

    public function handle()
    {
        $yesterday = Carbon::yesterday()->toDateTimeString();

        $files = Finder::create()
            ->in(Storage::disk('tmp')->path(''))
            ->date("<= {$yesterday}")
            ->files();

        foreach ($files as $file) {
            unlink($file->getRealPath());
        }
    }
}
