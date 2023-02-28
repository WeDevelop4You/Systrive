<?php

namespace App\Misc\Navigation\Responses;

use App\Account\Settings\Responses\SettingsOverviewResponse;
use Domain\Company\Models\Company;
use Illuminate\Support\Facades\Auth;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Menu\Helpers\VueRouteHelper;
use Support\Client\Components\Menu\Items\CustomMenuItemComponent;
use Support\Client\Components\Menu\Items\MenuItemComponent;
use Support\Client\Components\Menu\MenuComponent;
use Support\Client\Components\Menu\Types\GroupMenuTypeComponent;
use Support\Client\Components\Misc\IconComponent;
use Support\Client\Response;
use Support\Enums\Component\IconType;
use Support\Enums\Component\NavigationCustomItemType;
use Support\Enums\Component\TargetType;
use Support\Helpers\ApplicationHelper;

class NavigationResponse extends AbstractResponse
{
    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        $showSwitcher = Auth::user()->isSuperAdmin() || Company::count() > 1;

        return Response::create()
            ->addComponent(
                MenuComponent::create()
                    ->setNav()
                    ->addType(
                        GroupMenuTypeComponent::create()
                            ->addItems([
                                $this->createSettings(),
                            ])
                    )
                    ->addDivider()
                    ->addType(
                        GroupMenuTypeComponent::create()
                            ->addItem(
                                CustomMenuItemComponent::create()
                                    ->setTitle(trans('word.dark.mode'))
                                    ->setType(NavigationCustomItemType::DARK_MODE_SWITCH)
                            )
                    )
                    ->addDivider()
                    ->addType(
                        GroupMenuTypeComponent::create()
                            ->addItemIf($showSwitcher, $this->createSwitcher())
                            ->addItem(
                                MenuItemComponent::create()
                                    ->setTitle(trans('word.logout'))
                                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_SIGN_OUT_ALT))
                                    ->setAction(
                                        VuexAction::create()->dispatch('auth/logout')
                                    )
                            )
                    )
            );
    }

    /**
     * @return MenuItemComponent
     */
    private function createSettings(): MenuItemComponent
    {
        $nav = MenuItemComponent::create()
            ->setTitle(trans('word.settings'))
            ->setPrepend(IconComponent::create()->setType(IconType::FAS_COG));

        if (ApplicationHelper::isAccountDomain()) {
            return $nav->setRoute(
                VueRouteHelper::create()->setName('settings')
            );
        }

        return $nav->setHref(route('account.view.settings', SettingsOverviewResponse::DEFAULT_PAGE));
    }

    /**
     * @return MenuItemComponent
     */
    private function createSwitcher(): MenuItemComponent
    {
        $nav = MenuItemComponent::create()
            ->setTitle(trans('word.switcher.switcher'))
            ->setPrepend(IconComponent::create()->setType(IconType::FAS_RANDOM));

        if (ApplicationHelper::isCompanyDomain()) {
            return $nav->setRoute(VueRouteHelper::createSwitcher());
        }

        return $nav->setHref(route('company.view.switcher'), TargetType::SELF);
    }
}
