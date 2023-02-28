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
use Support\Client\Components\Menu\Helpers\VueRouteHelper;
use Support\Client\Components\Menu\Items\CreateMenuItemComponent;
use Support\Client\Components\Menu\Items\MenuItemComponent;
use Support\Client\Components\Menu\MenuComponent;
use Support\Client\Components\Menu\Types\CollapseMenuTypeComponent;
use Support\Client\Components\Menu\Types\GroupMenuTypeComponent;
use Support\Client\Components\Misc\IconComponent;
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
        $navbar = MenuComponent::create()
            ->setShaped()
            ->addType($this->createDefaultNavigationItems());

        if (
            $this->company->cms()->exists() &&
            $this->company->hasCMSModule() &&
            Auth::user()->hasPermission('cms.view')
        ) {
            $navbar->addDivider();
            $navbar->addSubheader(trans('word.cms.cms'));
            $navbar->addTypes($this->createCmsNavigationItems());
        }

        if (
            $this->system instanceof System &&
            $this->company->hasSystemModule() &&
            Auth::user()->hasPermission('system.view')
        ) {
            $navbar->addDivider();
            $navbar->addSubheader(trans('word.system.system'));
            $navbar->addTypes([
                $this->createSystemDomainNavigationItems(),
                $this->createSystemDNSNavigationItems(),
                $this->createSystemDatabaseNavigationItems(),
                $this->createSystemMailDomainNavigationItems(),
            ]);
        }

        if (Auth::user()->hasPermission('user.view', 'role.view')) {
            $navbar->addDivider();
            $navbar->addSubheader(trans('word.admin.admin'));
            $navbar->addTypes([
                $this->createAdminNavigationItems(),
            ]);
        }

        return Response::create()
            ->addComponent($navbar);
    }

    /**
     * @return GroupMenuTypeComponent
     */
    private function createDefaultNavigationItems(): GroupMenuTypeComponent
    {
        return GroupMenuTypeComponent::create()
            ->addItem(
                MenuItemComponent::create()
                    ->setTitle(trans('word.dashboard'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_HOME))
                    ->setRoute(VueRouteHelper::createCompany($this->company))
            );
    }

    private function createCmsNavigationItems(): array
    {
        return $this->company->cms->map(function (Cms $cms) {
            $tables = $cms->tables()->map(function (CmsTable $table) use ($cms) {
                return MenuItemComponent::create()
                    ->setTitle($table->label)
                    ->setRoute(VueRouteHelper::create()
                        ->setName('cms.table')
                        ->setParams([
                            'cmsName' => $cms->database,
                            'tableName' => $table->name,
                        ]));
            })->addIf(
                Auth::user()->isSuperAdmin(),
                CreateMenuItemComponent::create()
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

            return CollapseMenuTypeComponent::create()
                ->setTitle($cms->name)
                ->addItems($tables);
        })->toArray();
    }

    /**
     * @return CollapseMenuTypeComponent
     */
    private function createSystemDomainNavigationItems(): CollapseMenuTypeComponent
    {
        return CollapseMenuTypeComponent::create()
            ->setTitle(trans('word.domains'))
            ->setIcon(IconComponent::create()->setType(IconType::FAS_GLOBE))
            ->addItems(
                $this->system->domains->map(function (SystemDomain $domain) {
                    return MenuItemComponent::create()
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
     * @return CollapseMenuTypeComponent
     */
    private function createSystemDNSNavigationItems(): CollapseMenuTypeComponent
    {
        return CollapseMenuTypeComponent::create()
            ->setTitle(trans('word.dns'))
            ->setIcon(IconComponent::create()->setType(IconType::FAS_SITEMAP))
            ->addItems(
                $this->system->dns->map(function (SystemDNS $dns) {
                    return MenuItemComponent::create()
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
     * @return CollapseMenuTypeComponent
     */
    private function createSystemDatabaseNavigationItems(): CollapseMenuTypeComponent
    {
        return CollapseMenuTypeComponent::create()
            ->setTitle(trans('word.databases'))
            ->setIcon(IconComponent::create()->setType(IconType::FAS_SERVER))
            ->addItems(
                $this->system->databases->map(function (SystemDatabase $database) {
                    return MenuItemComponent::create()
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
     * @return CollapseMenuTypeComponent
     */
    private function createSystemMailDomainNavigationItems(): CollapseMenuTypeComponent
    {
        return CollapseMenuTypeComponent::create()
            ->setTitle(trans('word.mail.domains'))
            ->setIcon(IconComponent::create()->setType(IconType::FAS_MAIL_BULK))
            ->addItems(
                $this->system->mailDomains->map(function (SystemMailDomain $mailDomain) {
                    return MenuItemComponent::create()
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
     * @return GroupMenuTypeComponent
     */
    private function createAdminNavigationItems(): GroupMenuTypeComponent
    {
        $user = Auth::user();

        return GroupMenuTypeComponent::create()
            ->addItemIf(
                $user->hasPermission('user.view'),
                MenuItemComponent::create()
                    ->setTitle(trans('word.users'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_USERS_COG))
                    ->setRoute(VueRouteHelper::create()->setName('admin.users'))
            )
            ->addItemIf(
                $user->hasPermission('role.view'),
                MenuItemComponent::create()
                    ->setTitle(trans('word.roles'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_USER_SHIELD))
                    ->setRoute(VueRouteHelper::create()->setName('admin.roles'))
            );
    }
}
