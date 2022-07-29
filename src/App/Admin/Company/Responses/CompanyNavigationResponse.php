<?php

namespace App\Admin\Company\Responses;

use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemDatabase;
use Domain\System\Models\SystemDNS;
use Domain\System\Models\SystemDomain;
use Domain\System\Models\SystemMailDomain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\IconTypes;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Navbar\Helpers\VueRouteHelper;
use Support\Response\Components\Navbar\NavbarComponent;
use Support\Response\Components\Navbar\Navigations\CollapseNavigationComponent;
use Support\Response\Components\Navbar\Navigations\GroupNavigationComponent;
use Support\Response\Components\Navbar\Navigations\Items\NavigationItemComponent;
use Support\Response\Components\Utils\TooltipComponent;
use Support\Response\Response;

class CompanyNavigationResponse extends AbstractResponse
{
    /**
     * @var System|null
     */
    private readonly System|null $system;

    protected function __construct(
        private readonly Company $company
    ) {
        $this->system = $company->system()
            ->with(['domains', 'dns', 'databases', 'mailDomains'])
            ->first();
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        $navbar = NavbarComponent::create()
            ->setShaped()
            ->addItem($this->createDefaultNavigationItems());

        if ($this->system instanceof System) {
            $navbar->addDivider();
            $navbar->addSubheader(trans('word.system.system'));
            $navbar->addItems([
                $this->createSystemDomainNavigationItems(),
                $this->createSystemDNSNavigationItems(),
                $this->createSystemDatabaseNavigationItems(),
                $this->createSystemMailDomainNavigationItems(),
            ]);
        }

        if (Auth::user()->hasPermission('user.view', 'role.view')) {
            $navbar->addDivider();
            $navbar->addSubheader(trans('word.admin.admin'));
            $navbar->addItems([
                $this->createAdminNavigationItems(),
            ]);
        }

        return Response::create()
            ->addComponent($navbar);
    }

    /**
     * @return GroupNavigationComponent
     */
    private function createDefaultNavigationItems(): GroupNavigationComponent
    {
        return GroupNavigationComponent::create()
            ->addNavigation(
                NavigationItemComponent::create()
                    ->setTitle(trans('word.dashboard'))
                    ->setPrepend(IconComponent::create()->setType(IconTypes::FAS_HOME))
                    ->setRoute(VueRouteHelper::getCompany($this->company))
            );
    }

    /**
     * @return CollapseNavigationComponent
     */
    private function createSystemDomainNavigationItems(): CollapseNavigationComponent
    {
        return CollapseNavigationComponent::create()
            ->setTitle(trans('word.domains'))
            ->setIcon(IconComponent::create()->setType(IconTypes::FAS_GLOBE))
            ->setNavigation(
                $this->system->domains->map(function (SystemDomain $domain) {
                    return NavigationItemComponent::create()
                        ->setTitle($domain->name)
                        ->setTooltip(
                            TooltipComponent::create()
                                ->setText($domain->name)
                                ->setOpenDelay(1000)
                                ->setTop()
                        )
                        ->setRoute(
                            VueRouteHelper::create()
                                ->setName('company.domain')
                                ->setParams(['domainName' => $domain->name])
                        );
                })->toArray()
            );
    }

    /**
     * @return CollapseNavigationComponent
     */
    private function createSystemDNSNavigationItems(): CollapseNavigationComponent
    {
        return CollapseNavigationComponent::create()
            ->setTitle(trans('word.dns'))
            ->setIcon(IconComponent::create()->setType(IconTypes::FAS_SITEMAP))
            ->setNavigation(
                $this->system->dns->map(function (SystemDNS $dns) {
                    return NavigationItemComponent::create()
                        ->setTitle($dns->name)
                        ->setRoute(
                            VueRouteHelper::create()
                                ->setName('company.dns')
                                ->setParams(['domainNameServer' => $dns->name])
                        );
                })->toArray()
            );
    }

    /**
     * @return CollapseNavigationComponent
     */
    private function createSystemDatabaseNavigationItems(): CollapseNavigationComponent
    {
        return CollapseNavigationComponent::create()
            ->setTitle(trans('word.databases'))
            ->setIcon(IconComponent::create()->setType(IconTypes::FAS_SERVER))
            ->setNavigation(
                $this->system->databases->map(function (SystemDatabase $database) {
                    return NavigationItemComponent::create()
                        ->setTitle(Str::after($database->name, "{$this->company->name}_"))
                        ->setRoute(
                            VueRouteHelper::create()
                                ->setName('company.database')
                                ->setParams(['databaseName' => $database->name])
                        );
                })->toArray()
            );
    }

    /**
     * @return CollapseNavigationComponent
     */
    private function createSystemMailDomainNavigationItems(): CollapseNavigationComponent
    {
        return CollapseNavigationComponent::create()
            ->setTitle(trans('word.mail.domains'))
            ->setIcon(IconComponent::create()->setType(IconTypes::FAS_MAIL_BULK))
            ->setNavigation(
                $this->system->mailDomains->map(function (SystemMailDomain $mailDomain) {
                    return NavigationItemComponent::create()
                        ->setTitle($mailDomain->name)
                        ->setRoute(
                            VueRouteHelper::create()
                                ->setName('company.mail')
                                ->setParams(['mailDomainName' => $mailDomain->name])
                        );
                })->toArray()
            );
    }

    /**
     * @return GroupNavigationComponent
     */
    private function createAdminNavigationItems(): GroupNavigationComponent
    {
        $user = Auth::user();

        return GroupNavigationComponent::create()
            ->addNavigationIf(
                $user->hasPermission('user.view'),
                NavigationItemComponent::create()
                    ->setTitle(trans('word.users'))
                    ->setPrepend(IconComponent::create()->setType(IconTypes::FAS_USERS_COG))
                    ->setRoute(VueRouteHelper::create()->setName('company.users'))
            )
            ->addNavigationIf(
                $user->hasPermission('role.view'),
                NavigationItemComponent::create()
                    ->setTitle(trans('word.roles'))
                    ->setPrepend(IconComponent::create()->setType(IconTypes::FAS_USER_SHIELD))
                    ->setRoute(VueRouteHelper::create()->setName('company.roles'))
            );
    }
}
