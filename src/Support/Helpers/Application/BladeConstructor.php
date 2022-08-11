<?php

    namespace Support\Helpers\Application;

    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Blade;
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\View;
    use Illuminate\Support\Js;
    use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Str;
    use Illuminate\View\View as BladeView;
    use Support\Enums\SessionKeyTypes;
    use Support\Response\Response;
    use Symfony\Component\Finder\Finder;
    use Symfony\Component\Finder\SplFileInfo;
    use function Termwind\render;

    class BladeConstructor extends ServiceProvider
    {
        private function __construct(
            Application $app,
            private string $application
        ) {
            parent::__construct($app);

            $this->createViews();
            $this->createComponents();
            $this->createViewComposer();
        }

        /**
         * @param Application $app
         * @param string      $application
         *
         * @return BladeConstructor
         */
        public static function create(Application $app, string $application): BladeConstructor
        {
            return new static($app, $application);
        }

        /**
         * @return void
         */
        private function createViews(): void
        {
            $finder = new Finder();
            $path = base_path(app_path(ucfirst($this->application)));

            $filter = function (SplFileInfo $file) {
                if (!\in_array($file->getBasename(), ['Views', 'views'])) {
                    return false;
                }

                return true;
            };

            $paths = $finder->in($path)
                ->filter($filter)
                ->directories();

            foreach ($paths as $path) {
                $this->loadViewsFrom($path->getRealPath(), $this->application);
            }
        }

        /**
         * @return void
         */
        private function createComponents(): void
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

            $namespaces = Collection::make($files)
                ->map(function (SplFileInfo $file) {
                    return App::getNamespace().
                        Str::of($file->getPathname())
                            ->after(app_path().'/')
                            ->replace(['/', '.php'], ['\\', '']);
                })
                ->values()
                ->toArray();

            $this->loadViewComponentsAs($this->application, $namespaces);
        }

        private function createViewComposer()
        {
            View::composer('*', function (BladeView $view) {
                $data = Collection::make([
                    Session::get(SessionKeyTypes::KEEP->value),
                    Session::pull(SessionKeyTypes::ONCE->value)
                ])
                ->whereNotNull()
                ->values()
                ->toArray();

                $view->with('response', Js::from($data));
            });
        }
    }
