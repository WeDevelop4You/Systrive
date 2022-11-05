<?php

namespace App\Console\Commands\Generate;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GenerateTranslationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:translations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a file to easily import all frontend translations';

    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;

    /**
     * @var array
     */
    private array $imports = [];

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->filesystem = new Filesystem();

        $data = $this->importFiles();
        $data .= "export default {\n";
        $data .= $this->createLocalesList();
        $data .= "}";

        $this->filesystem->put(resource_path('admin/js/config/translations.js'), $data);
    }

    /**
     * @return string
     */
    private function createLocalesList(): string
    {
        $data = '';

        foreach ($this->imports as $locale => $import) {
            $import = implode(",\n\t\t...", $import);

            $data .= "\t{$locale}: {\n";
            $data .= "\t\t...{$import}\n";
            $data .= "\t},\n";
        }

        return $data;
    }

    /**
     * @return string
     */
    private function importFiles(): string
    {
        $data = '';
        $locales = config('translation.locales', []);

        foreach ($locales as $locale) {
            $import = $this->createImport('vuetify', $locale);

            $this->addImport($locale, $import);
            $data .= "import {$import} from 'vuetify/es5/locale/{$locale}'\n";

            $files = $this->filesystem->allFiles(base_path("lang/frontend/{$locale}"));

            foreach ($files as $file) {
                $import = $this->createImport($file->getBasename('.json'), $locale);

                $this->addImport($locale, $import);
                $data .= "import {$import} from '../../../../lang/frontend/{$locale}/{$file->getFilename()}'\n";
            }
        }

        return "{$data}\n";
    }

    /**
     * @param string $prefix
     * @param string $locale
     *
     * @return string
     */
    private function createImport(string $prefix, string $locale): string
    {
        $locale = strtoupper($locale);

        return "{$prefix}{$locale}";
    }

    /**
     * @param string $locale
     * @param string $import
     *
     * @return void
     */
    private function addImport(string $locale, string $import): void
    {
        $this->imports[$locale][] = $import;
    }
}
