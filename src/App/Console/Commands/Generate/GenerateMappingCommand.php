<?php

namespace App\Console\Commands\Generate;

use Error;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use stdClass;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class GenerateMappingCommand extends Command
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
     * @throws ReflectionException
     *
     * @return int
     */
    public function handle(): int
    {
        $this->newLine();
        $this->components->twoColumnDetail(
            '<fg=green;options=bold>Model</>',
            '<fg=green;options=bold>Generated mapping</>'
        );

        $this->getModelClasses()
            ->each(function (string $class) {
                try {
                    $mappingData = $this->createMappingData($class);

                    $this->generateMapping($mappingData);

                    $this->components->twoColumnDetail(
                        $class,
                        "{$mappingData->namespace}\\{$mappingData->filename}"
                    );
                } catch (Error) {
                    $this->components->twoColumnDetail(
                        "<fg=red>{$class}</>",
                        '<fg=red>Failed</>'
                    );
                }
            });

        $this->newLine();

        return 1;
    }

    /**
     * @return Collection
     */
    private function getModelClasses(): Collection
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

        return Collection::make($files)->map(function (SplFileInfo $file) {
            return Str::of($file->getPathname())
                ->after('src/')
                ->replace(['/', '.php'], ['\\', '']);
        })->filter(function (string $class) {
            return is_subclass_of($class, Model::class);
        });
    }

    /**
     * @param string $class
     *
     * @throws ReflectionException
     *
     * @return stdClass
     */
    private function createMappingData(string $class): stdClass
    {
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
        $mapping->filename = $filename;
        $mapping->constants = $this->getConstants($class);

        return $mapping;
    }

    /**
     * @param string $class
     *
     * @throws ReflectionException
     *
     * @return array
     */
    private function getConstants(string $class): array
    {
        /** @var Model $model */
        $model = new $class();
        $table = $model->getTable();
        $columns = Schema::connection($model->getConnectionName())->getColumnListing($table);
        $extraConstants = config("mapping.{$class}", []);

        $constants[0] = [
            'table' => $table,
        ];

        foreach ($columns as $column) {
            $key = $column;

            if ($key === 'table_id') {
                $key = "{$key}_";
            }

            $constants[1][$key] = $column;
        }

        foreach ($columns as $column) {
            $constants['table'][$column] = "{$table}.{$column}";
        }

        $relationships = $this->getRelationshipFromModel($class);
        foreach ($relationships as $relationship) {
            $name = Str::snake($relationship);

            $constants['relationship'][$name] = $relationship;
        }

        if (!\is_null($extraConstants)) {
            $constants = array_merge($constants, $extraConstants);
        }

        return $constants;
    }

    /**
     * @throws ReflectionException
     */
    private function getRelationshipFromModel(string $class): array
    {
        $reflector = new ReflectionClass($class);

        return collect($reflector->getMethods())
            ->filter(
                fn ($method) =>
                !empty($method->getReturnType()) &&
                Str::contains(
                    $method->getReturnType(),
                    'Illuminate\Database\Eloquent\Relations'
                ) &&
                !Str::contains(
                    $method->getName(),
                    ['where'],
                    true
                )
            )
            ->pluck('name')
            ->all();
    }

    private function generateMapping(object $mapping)
    {
        $filesystem = new Filesystem();
        $basePath = $mapping->path->beforeLast('/');

        if (!file_exists($basePath)) {
            mkdir($basePath, 0755, true);
        }

        $data = "<?php\n\n";
        $data .= "namespace {$mapping->namespace};\n\n";
        $data .= "class {$mapping->filename}\n";
        $data .= "{";

        foreach ($mapping->constants as $prefix => $constants) {
            $data .= "\n";
            foreach ($constants as $key => $value) {
                $key = strtoupper($key);

                if (\is_string($prefix)) {
                    $key = strtoupper($prefix) . "_{$key}";
                }

                $data .= "\tpublic const {$key} = ";
                $data .= $this->getValue($value);
                $data .= ";\n";
            }
        }

        $data .= "}\n";

        $filesystem->put($mapping->path, $data);
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    private function getValue(mixed $value): mixed
    {
        if (\is_string($value)) {
            return "'{$value}'";
        }

        if (\is_array($value)) {
            $array = implode("', '", $value);

            return "['{$array}']";
        }

        return $value;
    }
}
