<?php

    namespace Support\Helpers\Application;

    use Illuminate\Support\Arr;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Str;
    use Symfony\Component\Finder\Finder;

    class RouterConstructor
    {
        /**
         * @var string
         */
        private string $name;

        /**
         * @var Collection
         */
        private Collection $routeFiles;

        public function __construct(
            private Collection $routeConfig,
            string $application
        ) {
            $this->name = "{$application}.";
            $this->routeFiles = new Collection($routeConfig->get('files'));

            $this->initialize();
        }

        /**
         * @param Collection $routeConfig
         * @param string     $application
         *
         * @return RouterConstructor
         */
        public static function create(Collection $routeConfig, string $application): RouterConstructor
        {
            return new static($routeConfig, $application);
        }

        private function initialize()
        {
            $this->routeFiles->each(function (array $routeFile) {
                $routeFile = new Collection($routeFile);
                $files = $this->getAllRouteFiles($routeFile->get('filename'));

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
        private function getAllRouteFiles(string $fileName): Finder
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
            $maps = explode('/', $path);

            $map = Arr::first($maps);

            if (!is_null($map) && !in_array($map, ['Routes', 'Authentication'])) {
                $prefixes[] = Str::pluralStudly(strtolower($map));
            }

            return implode('/', $prefixes);
        }
    }
