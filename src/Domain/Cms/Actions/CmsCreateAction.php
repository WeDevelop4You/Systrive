<?php

namespace Domain\Cms\Actions;

use Domain\Cms\DataTransferObjects\CmsData;
use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Support\Enums\VestaCommand;
use Support\Exceptions\Custom\Vesta\VestaCommandException;
use Support\Exceptions\Custom\Vesta\VestaConnectionFailedException;
use Support\Services\Cms as CmsService;
use Support\Services\Vesta;

class CmsCreateAction
{
    /**
     * @var string
     */
    private readonly string $prefix;

    /**
     * CMSDatabaseCreateAction constructor.
     *
     * @param Company $company
     */
    public function __construct(
        private readonly Company $company,
    ) {
        $this->prefix = "{$this->company->system->username}_";
    }

    /**
     * @param CmsData $data
     *
     * @throws VestaCommandException
     * @throws VestaConnectionFailedException
     *
     * @return Cms
     */
    public function __invoke(CmsData $data): Cms
    {
        Vesta::api()->post(
            VestaCommand::CREATE_DATABASE,
            $this->company->system->username,
            $this->removePrefix($data->database),
            $this->removePrefix($data->username),
            $data->password,
        );

        $cms = new CMS();
        $cms->name = $data->name;
        $cms->database = $this->addPrefix($data->database);
        $cms->username = $this->addPrefix($data->username);
        $cms->password = $data->password;
        $cms->company_id = $this->company->id;
        $cms->save();

        CmsService::createConnection($cms);

        if (App::isLocal() && !\defined('STDIN')) {
            \define('STDIN', fopen("php://stdin", "r"));
        }

        Artisan::call('migrate', [
            '--database' => 'cms',
            '--path' => 'src/Domain/CMS/Migrations',
        ]);

        return $cms;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    private function addPrefix(string $value): string
    {
        return Str::start($value, $this->prefix);
    }

    private function removePrefix(string $value): string
    {
        return Str::after($value, $this->prefix);
    }
}
