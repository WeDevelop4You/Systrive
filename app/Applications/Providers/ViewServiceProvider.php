<?php

    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;

    class ViewServiceProvider extends ServiceProvider
    {
        public function boot()
        {
            $applications = array_keys(config('applications'));

            foreach ($applications as $application) {
                $namespace = strtolower($application);
                $path = sprintf('%s/../%s/Views', __DIR__, ucfirst($application));

                $this->loadViewsFrom($path, $namespace);
            }
        }
    }
