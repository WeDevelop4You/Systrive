<?php

namespace Support\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Js;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\View as BladeView;
use Support\Enums\SessionKeyType;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->createViewComposer();
        $this->load('general', support_path());

        Config::collect('applications')->keys()->each(function (string $application) {
            $this->load(strtolower($application));
        });
    }

    /**
     * @param string      $prefix
     * @param string|null $path
     *
     * @return void
     */
    private function load(string $prefix, string $path = null): void
    {
        $path = $path ?: application_path(ucfirst($prefix));

        $this->loadViews($path, $prefix);
        $this->loadComponents($path, $prefix);
    }

    /**
     * @param string $path
     * @param string $prefix
     *
     * @return void
     */
    private function loadViews(string $path, string $prefix): void
    {
        $finder = new Finder();

        $filter = function (SplFileInfo $file) {
            if (! \in_array($file->getBasename(), ['Views', 'views'])) {
                return false;
            }

            return true;
        };

        $paths = $finder->in($path)
            ->filter($filter)
            ->directories();

        foreach ($paths as $path) {
            View::addNamespace($prefix, $path->getRealPath());
        }
    }

    /**
     * @param string $path
     * @param string $prefix
     *
     * @return void
     */
    private function loadComponents(string $path, string $prefix): void
    {
        $finder = new Finder();

        $filter = function (SplFileInfo $file) {
            if (! str_ends_with($file->getPath(), 'components')) {
                return false;
            }

            return true;
        };

        $files = $finder->in($path)
            ->filter($filter)
            ->name('*.php')
            ->ignoreDotFiles(true)
            ->files();

        Collection::make($files)->each(function (SplFileInfo $file) use ($prefix) {
            $component = Str::of($file->getPathname())
                ->after('src/')
                ->replace(['/', '.php'], ['\\', ''])
                ->value();

            Blade::component(class: $component, prefix: $prefix);
        });
    }

    /**
     * @return void
     */
    private function createViewComposer(): void
    {
        View::composer('*', function (BladeView $view) {
            $data = Collection::make([
                Session::get(SessionKeyType::KEEP->value),
                Session::pull(SessionKeyType::ONCE->value),
            ])->whereNotNull()->values()->toArray();

            $view->with('response', Js::from($data));
        });
    }
}
