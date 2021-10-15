<?php

    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;

    class ComponentServiceProvider extends ServiceProvider
    {
        public function boot()
        {
            $applications = array_keys(config('applications'));

            foreach ($applications as $application) {
                $prefix = strtolower($application);
                $namespace = sprintf('App\%s\Views\components\AppLayout', ucfirst($prefix));

                $this->loadViewComponentsAs($prefix, [
                    $namespace,
                ]);
            }
        }
    }
