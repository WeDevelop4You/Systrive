<?php

namespace App\Admin\Startup\Responses;

use Auth;
use Domain\Company\Enums\CompanyUserStatusTypes;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\IconType;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Images\ImageComponent;
use Support\Response\Components\Navbar\Helpers\VueRouteHelper;
use Support\Response\Components\Navbar\NavbarComponent;
use Support\Response\Components\Navbar\Navigations\GroupNavigationComponent;
use Support\Response\Components\Navbar\Navigations\Items\NavigationItemComponent;
use Support\Response\Response;

class MainNavigationResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        $navbar = NavbarComponent::create()
            ->setShaped()
            ->addSubheader(trans('word.companies'))
            ->addItem($this->createCompanyNavigationItems());

        if (Auth::user()->isSuperAdmin()) {
            $navbar->addDivider()
                ->addSubheader(trans('word.super_admin'))
                ->addItem($this->createSuperAdminNavigationItems());
        }

        return Response::create()->addComponent($navbar);
    }

    private function createCompanyNavigationItems(): GroupNavigationComponent
    {
        return GroupNavigationComponent::create()
            ->setNavigation(
                Auth::user()
                ->whereCompanyStatus(CompanyUserStatusTypes::ACCEPTED)->get()
                ->map(function (Company $company) {
                    $image = "https://avatar.oxro.io/avatar.svg?name={$company->name}&rounded=250&caps=1";

                    return NavigationItemComponent::create()
                        ->setTitle($company->name)
                        ->setPrepend(
                            ImageComponent::create()
                                ->setSource($image)
                                ->setSize(28)
                        )
                        ->setRoute(
                            VueRouteHelper::createCompany($company)
                        );
                })->toArray()
            );
    }

    private function createSuperAdminNavigationItems(): GroupNavigationComponent
    {
        return GroupNavigationComponent::create()
            ->setNavigation([
                NavigationItemComponent::create()
                    ->setTitle(trans('word.users'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_USERS))
                    ->setRoute(VueRouteHelper::create()->setName('admin.users')),
                NavigationItemComponent::create()
                    ->setTitle(trans('word.companies'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_ADDRESS_CARD))
                    ->setRoute(VueRouteHelper::create()->setName('admin.companies')),
                NavigationItemComponent::create()
                    ->setTitle(trans('word.translations'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_LANGUAGE))
                    ->setRoute(VueRouteHelper::create()->setName('admin.translations')),
                NavigationItemComponent::create()
                    ->setTitle(trans('word.supervisor'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_RUNNING))
                    ->setRoute(VueRouteHelper::create()->setName('admin.supervisor')),
                NavigationItemComponent::create()
                    ->setTitle(trans('word.jobs'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_BUSINESS_TIME))
                    ->setRoute(VueRouteHelper::create()->setName('admin.jobs')),
            ]);
    }
}
