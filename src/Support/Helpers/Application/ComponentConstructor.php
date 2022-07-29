<?php

    namespace Support\Helpers\Application;

    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Str;
    use Symfony\Component\Finder\Finder;
    use Symfony\Component\Finder\SplFileInfo;

    class ComponentConstructor extends ServiceProvider
    {
        private function __construct(
            Application $app,
            private string $application
        ) {
            parent::__construct($app);

            $this->initialize();
        }

        /**
         * @param Application $app
         * @param string      $application
         *
         * @return ComponentConstructor
         */
        public static function create(Application $app, string $application): ComponentConstructor
        {
            return new static($app, $application);
        }

        private function initialize(): void
        {
            $namespaces = $this->getComponentNamespaces();

            $this->loadViewComponentsAs($this->application, $namespaces);
        }

        /**
         * @return array
         */
        private function getComponentNamespaces(): array
        {
            $finder = new Finder();
            $path = base_path(app_path(ucfirst($this->application)));

            $filter = function (SplFileInfo $file) {
                if (!str_ends_with($file->getPath(), 'components')) {
                    return false;
                }

                return true;
            };

            $files = $finder->in($path)
                ->filter($filter)
                ->name('*.php')
                ->ignoreDotFiles(true)
                ->files();

            $namespaces = new Collection($files);

            return $namespaces->values()->map(function (SplFileInfo $file) {
                return App::getNamespace().
                    Str::of($file->getPathname())
                        ->after(app_path().'/')
                        ->replace(['/', '.php'], ['\\', '']);
            })->toArray();
        }
    }
