<?php

namespace Support\Response\Components\Navbar\Helpers;

use Domain\Company\Models\Company;

class VueRouteHelper
{
    private array $data = [];

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

    /**
     * @param Company $company
     *
     * @return VueRouteHelper
     */
    public static function getCompany(Company $company): VueRouteHelper
    {
        return static::create()->setName('company.dashboard')
            ->setParams(['companyName' => $company->slug]);
    }

    /**
     * @param string $page
     *
     * @return VueRouteHelper
     */
    public static function getAccountSettings(string $page): VueRouteHelper
    {
        return static::create()->setName('account.settings')
            ->setParams(['page' => $page]);
    }
}
