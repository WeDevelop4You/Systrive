<?php

namespace Support\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\Finder;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $files = Finder::create()
            ->in(application_path())
            ->name('channels.php')
            ->files();

        foreach ($files as $file) {
            include $file->getRealPath();
        }
    }
}
