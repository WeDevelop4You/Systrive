<?php

namespace App\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class FrontendTranslationImporter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:frontend-import-translation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a file for frontend translation importer';

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

        $this->filesystem->put(base_path('lang/frontend/index.js'), $data);
    }

    /**
     * @return string
     */
    private function createLocalesList(): string
    {
        $data = '';
        $locales = config('translation.locales', []);

        foreach ($locales as $locale) {
            $data .= "    {$locale}: {\n";
            $data .= $this->importFiles($locale);
            $data .= "    },\n";
        }

        return $data;
    }

    /**
     * @param string $locale
     * @return string
     */
    private function importFiles(string $locale): string
    {
        $files = $this->filesystem->allFiles(base_path("lang/frontend/{$locale}"));

        $data = "        ...require('vuetify/es5/locale/{$locale}'),\n";

        foreach ($files as $file) {
            $data .= "        ...require('./{$locale}/{$file->getFilename()}'),\n";
        }

        return $data;
    }
}
