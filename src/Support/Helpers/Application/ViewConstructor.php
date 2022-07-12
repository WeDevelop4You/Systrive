<?php

    namespace Support\Helpers\Application;

    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Support\ServiceProvider;
    use Symfony\Component\Finder\Finder;
    use Symfony\Component\Finder\SplFileInfo;

    class ViewConstructor extends ServiceProvider
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
         * @return ViewConstructor
         */
        public static function create(Application $app, string $application): ViewConstructor
        {
            return new static($app, $application);
        }

        private function initialize(): void
        {
            $paths = $this->getViewPaths();

            foreach ($paths as $path) {
                $this->loadViewsFrom($path->getRealPath(), $this->application);
            }
        }

        /**
         * @return Finder
         */
        private function getViewPaths(): Finder
        {
            $finder = new Finder();
            $path = base_path(app_path(ucfirst($this->application)));

            $filter = function (SplFileInfo $file) {
                if (!\in_array($file->getBasename(), ['Views', 'views'])) {
                    return false;
                }

                return true;
            };

            return $finder->in($path)
                ->filter($filter)
                ->directories();
        }
    }
