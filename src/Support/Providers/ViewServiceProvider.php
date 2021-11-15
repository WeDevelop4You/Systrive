<?php

    namespace Support\Providers;

    use Illuminate\Support\ServiceProvider;

    class ViewServiceProvider extends ServiceProvider
    {
        public function boot()
        {
            $applications = array_keys(config('applications'));

            foreach ($applications as $application) {
                $namespace = strtolower($application);
                $path = base_path(app_path(ucfirst($namespace) . '/Views'));

                $this->loadViewsFrom($path, $namespace);
            }
        }
    }
