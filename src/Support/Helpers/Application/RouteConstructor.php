<?php

    namespace Support\Helpers\Application;

    use Illuminate\Routing\Route as Routes;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Route as RouteList;
    use Illuminate\Support\Str;
    use Symfony\Component\Finder\Finder;

    class RouteConstructor
    {
        /**
         * @var string
         */
        private string $name;

        /**
         * @var array
         */
        private array $ignorePlurals;

        /**
         * @var Collection
         */
        private Collection $routeFiles;

        /**
         * RouteConstructor constructor.
         *
         * @param Collection $routeConfig
         * @param string     $application
         */
        private function __construct(
            private readonly Collection $routeConfig,
            string                      $application
        ) {
            $this->name = "{$application}.";
            $this->ignorePlurals = $routeConfig->get('ignore_plurals', []);
            $this->routeFiles = Collection::make($routeConfig->get('files'));

            $this->initialize();
        }

        /**
         * @param Collection $routeConfig
         * @param string     $application
         *
         * @return RouteConstructor
         */
        public static function create(Collection $routeConfig, string $application): RouteConstructor
        {
            return new static($routeConfig, $application);
        }

        /**
         * @return void
         */
        private function initialize(): void
        {
            $this->routeFiles->each(function (array $routeFile) {
                $routeFile = Collection::make($routeFile);
                $files = $this->getRouteFiles($routeFile->get('filename'));

                foreach ($files as $file) {
                    $prefix = $this->generatePrefix($file->getRelativePath(), $routeFile->get('prefix'));

                    Route::prefix($prefix)
                        ->name($this->name)
                        ->domain($this->routeConfig->get('domain'))
                        ->middleware($routeFile->get('middleware'))
                        ->group($file->getRealPath());
                }
            });
        }

        /**
         * @param string $fileName
         *
         * @return Finder
         */
        private function getRouteFiles(string $fileName): Finder
        {
            $finder = new Finder();

            return $finder->name($fileName)
                ->in($this->routeConfig->get('path'))
                ->files();
        }

        /**
         * @param string      $path
         * @param string|null $prefix
         *
         * @return string
         */
        private function generatePrefix(string $path, ?string $prefix = null): string
        {
            $prefixes = Arr::wrap($prefix);
            $directories = explode('/', $path);

            $directory = strtolower(Arr::first($directories, null, ''));

            if (!empty($directory) && !\in_array($directory, ['routes', 'authentication'])) {
                $prefixes[] = \array_key_exists($directory, $this->ignorePlurals)
                    ? $this->ignorePlurals[$directory]
                    : Str::plural($directory);
            }

            return implode('/', $prefixes);
        }

        /**
         * @return void
         */
        public static function createDataTableMacro(): void
        {
            Route::macro('dataTable', function (string $controller, string $name, string $prefix = '') {
                Route::prefix("{$prefix}/table")->controller($controller)->group(function () use ($name) {
                    Route::get('items', 'action')->name("{$name}.table.items");
                    Route::get('headers', 'index')->name("{$name}.table.headers");
                });
            });
        }

        /**
         * @param string $application
         *
         * @return Collection
         */
        public static function getApiRoutes(string $application): Collection
        {
            return Collection::make(RouteList::getRoutes())
                ->mapWithKeys(function (Routes $route, int $index) use ($application) {
                    if (\in_array('api', $route->getAction('middleware')) &&
                        Str::startsWith($route->getName(), "{$application}.")
                    ) {
                        $name = $route->getName() ?: "no_name_{$index}";
                        $uri = '/' . trim($route->uri(), '/');

                        return [$name => $uri];
                    }

                    return [];
                });
        }
    }
