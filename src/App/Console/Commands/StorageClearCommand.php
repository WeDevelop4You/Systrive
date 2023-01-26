<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Finder;

class StorageClearCommand extends Command
{
    protected $signature = 'storage:clear {disk : Storage disk}';

    protected $description = 'deletes all the files in tmp';

    public function handle()
    {
        $yesterday = Carbon::yesterday()->toDateTimeString();
        $path = Storage::disk($this->argument('disk'))->path('');

        $files = Finder::create()
            ->in($path)
            ->date("<= {$yesterday}")
            ->files();

        foreach ($files as $file) {
            unlink($file->getRealPath());
        }
    }
}
