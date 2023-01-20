<?php

namespace App\Misc\Navigation\Responses;

use App\Account\Settings\Responses\SettingsOverviewResponse;
use Domain\Company\Models\Company;
use Illuminate\Support\Facades\Auth;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\Components\Navbar\Helpers\VueRouteHelper;
use Support\Client\Components\Navbar\NavbarComponent;
use Support\Client\Components\Navbar\Navigations\GroupNavigationComponent;
use Support\Client\Components\Navbar\Navigations\Items\NavigationCustomItemComponent;
use Support\Client\Components\Navbar\Navigations\Items\NavigationItemComponent;
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
                NavbarComponent::create()
                    ->setNav()
                    ->addItem(
                        GroupNavigationComponent::create()
                            ->setNavigation([
                                $this->createSettings(),
                            ])
                    )
                    ->addDivider()
                    ->addItem(
                        GroupNavigationComponent::create()
                            ->addNavigation(
                                NavigationCustomItemComponent::create()
                                    ->setTitle(trans('word.dark.mode'))
                                    ->setType(NavigationCustomItemType::DARK_MODE_SWITCH)
                            )
                    )
                    ->addDivider()
                    ->addItem(
                        GroupNavigationComponent::create()
                            ->addNavigationIf($showSwitcher, $this->createSwitcher())
                            ->addNavigation(
                                NavigationItemComponent::create()
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
     * @return NavigationItemComponent
     */
    private function createSettings(): NavigationItemComponent
    {
        $nav = NavigationItemComponent::create()
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
     * @return NavigationItemComponent
     */
    private function createSwitcher(): NavigationItemComponent
    {
        $nav = NavigationItemComponent::create()
            ->setTitle(trans('word.switcher.switcher'))
            ->setPrepend(IconComponent::create()->setType(IconType::FAS_RANDOM));

        if (ApplicationHelper::isCompanyDomain()) {
            return $nav->setRoute(VueRouteHelper::createSwitcher());
        }

        return $nav->setHref(route('company.view.switcher'), TargetType::SELF);
    }
}
