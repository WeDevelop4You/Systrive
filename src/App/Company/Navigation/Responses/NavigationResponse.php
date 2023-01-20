<?php

namespace App\Company\Navigation\Responses;

use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemDatabase;
use Domain\System\Models\SystemDNS;
use Domain\System\Models\SystemDomain;
use Domain\System\Models\SystemMailDomain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\Components\Navbar\Helpers\VueRouteHelper;
use Support\Client\Components\Navbar\NavbarComponent;
use Support\Client\Components\Navbar\Navigations\CollapseNavigationComponent;
use Support\Client\Components\Navbar\Navigations\GroupNavigationComponent;
use Support\Client\Components\Navbar\Navigations\Items\NavigationCreateItemComponent;
use Support\Client\Components\Navbar\Navigations\Items\NavigationItemComponent;
use Support\Client\Components\Utils\TooltipComponent;
use Support\Client\Response;
use Support\Enums\Component\IconType;

class NavigationResponse extends AbstractResponse
{
    /**
     * @var System|null
     */
    private readonly System|null $system;

    protected function __construct(
        private readonly Company $company
    ) {
        $this->system = $company->system()
            ->with([
                'dns',
                'domains',
                'databases',
                'mailDomains',
            ])
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        $navbar = NavbarComponent::create()
            ->setShaped()
            ->addItem($this->createDefaultNavigationItems());

        if (
            $this->company->cms()->exists() &&
            $this->company->hasCMSModule() &&
            Auth::user()->hasPermission('cms.view')
        ) {
            $navbar->addDivider();
            $navbar->addSubheader(trans('word.cms.cms'));
            $navbar->addItems($this->createCmsNavigationItems());
        }

        if (
            $this->system instanceof System &&
            $this->company->hasSystemModule() &&
            Auth::user()->hasPermission('system.view')
        ) {
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
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_HOME))
                    ->setRoute(VueRouteHelper::createCompany($this->company))
            );
    }

    private function createCmsNavigationItems(): array
    {
        return $this->company->cms->map(function (Cms $cms) {
            $tables = $cms->tables()->map(function (CmsTable $table) use ($cms) {
                return NavigationItemComponent::create()
                    ->setTitle($table->label)
                    ->setRoute(VueRouteHelper::create()
                        ->setName('cms.table')
                        ->setParams([
                            'cmsName' => $cms->database,
                            'tableName' => $table->name,
                        ]));
            })->addIf(
                Auth::user()->isSuperAdmin(),
                NavigationCreateItemComponent::create()
                    ->setAction(
                        VuexAction::create()->dispatch(
                            'cms/table/create',
                            route('company.cms.table.create', [
                                $this->company->id,
                                $cms->id,
                            ])
                        )
                    )
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setTop()
                            ->setText(trans('word.create.table'))
                    )
            )->toArray();

            return CollapseNavigationComponent::create()
                ->setTitle($cms->name)
                ->setNavigation($tables);
        })->toArray();
    }

    /**
     * @return CollapseNavigationComponent
     */
    private function createSystemDomainNavigationItems(): CollapseNavigationComponent
    {
        return CollapseNavigationComponent::create()
            ->setTitle(trans('word.domains'))
            ->setIcon(IconComponent::create()->setType(IconType::FAS_GLOBE))
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
                                ->setName('system.domain')
                                ->setParams(['name' => $domain->name])
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
            ->setIcon(IconComponent::create()->setType(IconType::FAS_SITEMAP))
            ->setNavigation(
                $this->system->dns->map(function (SystemDNS $dns) {
                    return NavigationItemComponent::create()
                        ->setTitle($dns->name)
                        ->setRoute(
                            VueRouteHelper::create()
                                ->setName('system.dns')
                                ->setParams(['name' => $dns->name])
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
            ->setIcon(IconComponent::create()->setType(IconType::FAS_SERVER))
            ->setNavigation(
                $this->system->databases->map(function (SystemDatabase $database) {
                    return NavigationItemComponent::create()
                        ->setTitle(Str::after($database->name, "{$this->company->name}_"))
                        ->setRoute(
                            VueRouteHelper::create()
                                ->setName('system.database')
                                ->setParams(['name' => $database->name])
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
            ->setIcon(IconComponent::create()->setType(IconType::FAS_MAIL_BULK))
            ->setNavigation(
                $this->system->mailDomains->map(function (SystemMailDomain $mailDomain) {
                    return NavigationItemComponent::create()
                        ->setTitle($mailDomain->name)
                        ->setRoute(
                            VueRouteHelper::create()
                                ->setName('system.mail')
                                ->setParams(['name' => $mailDomain->name])
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
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_USERS_COG))
                    ->setRoute(VueRouteHelper::create()->setName('admin.users'))
            )
            ->addNavigationIf(
                $user->hasPermission('role.view'),
                NavigationItemComponent::create()
                    ->setTitle(trans('word.roles'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_USER_SHIELD))
                    ->setRoute(VueRouteHelper::create()->setName('admin.roles'))
            );
    }
}
