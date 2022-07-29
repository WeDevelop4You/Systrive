<?php

namespace App\Console\Commands\Generate;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GenerateTranslation extends Command
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

    public function __construct()
    {
        $this->filesystem = new Filesystem();

        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $data = "export default {\n";
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
        $locales = config('translation.locales', []);

        foreach ($locales as $locale) {
            $data .= "\t{$locale}: {\n";
            $data .= $this->importFiles($locale);
            $data .= "\t},\n";
        }

        return $data;
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    private function importFiles(string $locale): string
    {
        $files = $this->filesystem->allFiles(base_path("lang/frontend/{$locale}"));

        $data = "\t\t...require('vuetify/es5/locale/{$locale}'),\n";

        foreach ($files as $file) {
            $data .= "\t\t...require('../../../../lang/frontend/{$locale}/{$file->getFilename()}'),\n";
        }

        return $data;
    }
}
