<?php

namespace Support\Client\Components\Navbar\Helpers;

use App\Account\Settings\Responses\SettingsOverviewResponse;
use Domain\Company\Models\Company;

class VueRouteHelper
{
    private array $data = [];

    /**
     * VueRouteHelper constructor.
     */
    private function __construct()
    {
        //
    }

    /**
     * @return static
     */
    public static function create(): static
    {
        return new static();
    }

    /**
     * @return VueRouteHelper
     */
    public static function createSwitcher(): VueRouteHelper
    {
        return static::create()->setName('switcher');
    }

    /**
     * @return VueRouteHelper
     */
    public static function createDashboard(): VueRouteHelper
    {
        return static::create()->setName('dashboard');
    }

    /**
     * @param Company $company
     *
     * @return VueRouteHelper
     */
    public static function createCompany(Company $company): VueRouteHelper
    {
        return static::create()->setName('dashboard')->setParams(['companyName' => $company->slug]);
    }

    /**
     * @param string $page
     *
     * @return VueRouteHelper
     */
    public static function createAccountSettings(string $page = SettingsOverviewResponse::DEFAULT_PAGE): VueRouteHelper
    {
        return static::create()->setName('settings')->setParams(['page' => $page]);
    }

    /**
     * @param string $name
     *
     * @return VueRouteHelper
     */
    public function setName(string $name): VueRouteHelper
    {
        return $this->setData('name', $name);
    }

    /**
     * @param array $params
     *
     * @return VueRouteHelper
     */
    public function setParams(array $params): VueRouteHelper
    {
        return $this->setData('params', $params);
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return VueRouteHelper
     */
    private function setData(string $key, mixed $value): VueRouteHelper
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function export(): array
    {
        return $this->data;
    }
}
