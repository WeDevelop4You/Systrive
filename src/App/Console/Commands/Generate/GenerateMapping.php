<?php

namespace App\Console\Commands\Generate;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use stdClass;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class GenerateMapping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:mapping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a class with const of database table field foreach model';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->getModelClasses();

        return 1;
    }

    private function getModelClasses(): void
    {
        $finder = new Finder();
        $path = base_path('src/Domain');

        $filter = function (SplFileInfo $file) {
            return str_ends_with($file->getPath(), 'Models');
        };

        $files = $finder->in($path)
            ->filter($filter)
            ->name('*.php')
            ->ignoreDotFiles(true)
            ->files();

        $classes = new Collection($files);

        $classes->map(function (SplFileInfo $file) {
            return Str::of($file->getPathname())
                ->after('src/')
                ->replace(['/', '.php'], ['\\', '']);
        })->filter(function (string $class) {
            return is_subclass_of($class, Model::class);
        })->each(function (string $class) {
            $this->createMappingData($class);
        });
    }

    private function createMappingData(string $class): void
    {
        $model = new $class();

        $columns = Schema::getColumnListing($model->getTable());

        if (!is_null($columns)) {
            $constants = [];

            foreach ($columns as $column) {
                $constants[$column] = $column;
            }

            $namespace = Str::of($class)
                ->before('\\Models')
                ->append('\\Mappings');

            $filename = Str::of($class)
                ->afterLast('\\')
                ->append('TableMap');

            $path = Str::of($class)
                ->replace('\\', '/')
                ->before('/Models')
                ->prepend(base_path() . '/src/')
                ->append("/Mappings/{$filename}.php");

            $mapping = new stdClass();
            $mapping->path = $path;
            $mapping->namespace = $namespace;
            $mapping->fileName = $filename;
            $mapping->constants[] = $constants;

            $extraConstants = config("mapping.{$class}", []);

            if (!is_null($extraConstants)) {
                $mapping->constants = array_merge($mapping->constants, $extraConstants);
            }

            $this->generateMapping($mapping);

            $this->info("Generated {$mapping->fileName} ({$mapping->namespace})");
        }
    }

    private function generateMapping(object $mapping)
    {
        $filesystem = new Filesystem();
        $basePath = $mapping->path->beforeLast('/');

        if (!file_exists($basePath)) {
            mkdir($basePath, 0755, true);
        }

        $data = "<?php\n\n";
        $data .= "\tnamespace {$mapping->namespace};\n\n";
        $data .= "\tclass {$mapping->fileName}\n";
        $data .= "\t{";

        foreach ($mapping->constants as $suffix => $constants) {
            $data .= "\n";
            foreach ($constants as $key => $value) {
                $key = strtoupper($key);

                if (is_string($suffix)) {
                    $key = "{$key}_" . strtoupper($suffix);
                }

                $data .= "\t\tpublic const {$key} = '{$value}';\n";
            }
        }

        $data .= "\t}\n";

        $filesystem->put($mapping->path, $data);
    }
}
