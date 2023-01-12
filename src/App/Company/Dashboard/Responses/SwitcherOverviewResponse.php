<?php

namespace App\Company\Dashboard\Responses;

use Domain\Company\Enums\CompanyStatusTypes;
use Domain\Company\Enums\CompanyUserStatusTypes;
use Domain\Company\Models\Company;
use Domain\Company\Scopes\CompanyViewScope;
use Illuminate\Support\Facades\Auth;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Layouts\RowComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Misc\ContentComponent;
use Support\Client\Components\Misc\DividerComponent;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\Components\Misc\ImageComponent;
use Support\Client\Components\Navbar\Helpers\VueRouteHelper;
use Support\Client\Components\Navbar\NavbarComponent;
use Support\Client\Components\Navbar\Navigations\GroupNavigationComponent;
use Support\Client\Components\Navbar\Navigations\Items\NavigationContentItemComponent;
use Support\Client\Components\Navbar\Navigations\Items\NavigationItemComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Components\Popups\Modals\DialogComponent;
use Support\Client\Response;
use Support\Enums\Component\IconType;
use Support\Enums\Component\TargetType;
use Support\Enums\Component\Vuetify\VuetifyJustifyType;

class SwitcherOverviewResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                RowComponent::create()
                    ->setJustify(VuetifyJustifyType::CENTER)
                    ->addCol(
                        ColComponent::create()
                            ->setDefaultCol('auto')
                            ->setComponent(
                                CardComponent::create()
                                    ->setWidth(400)
                                    ->addAdditionalBodyClass('pa-0')
                                    ->setHeader(
                                        CardHeaderComponent::create()->setTitle(trans('word.switcher.switcher'))
                                    )
                                    ->setBody([
                                        ContentComponent::create()
                                            ->setValue(trans('text.switcher.company'))
                                            ->setClass('text-center'),
                                        DividerComponent::create(),
                                        $this->createCompaniesNavigation(),
                                    ])
                                    ->setBodyIf(
                                        Auth::user()->isSuperAdmin(),
                                        [
                                            DividerComponent::create(),
                                            $this->createAdminNavigation(),
                                        ]
                                    )
                            )
                    )
            );
    }

    /**
     * @return NavbarComponent
     */
    private function createCompaniesNavigation(): NavbarComponent
    {
        $navbar = NavbarComponent::create()->setNav();
        $companies = Auth::user()
            ->companies()
            ->withoutGlobalScope(CompanyViewScope::class)
            ->with('companyUser')
            ->get();

        if ($companies->isNotEmpty()) {
            return $navbar->addItem(
                GroupNavigationComponent::create()
                    ->setNavigation(
                        $companies->sortBy('pivot_status')
                            ->map(function (Company $company) {
                                $image = "https://avatar.oxro.io/avatar.svg?name={$company->name}&rounded=250&caps=1";

                                $item = NavigationItemComponent::create()
                                    ->setTitle($company->name)
                                    ->setPrepend(ImageComponent::create()->setSource($image)->setSize(28));

                                $this->setNavigationStatus($item, $company);

                                return $item;
                            })->toArray()
                    )
            );
        }

        return $navbar->addItem(
            GroupNavigationComponent::create()
                ->addNavigation(
                    NavigationContentItemComponent::create()->setTitle(trans('text.no.companies'))
                )
        );
    }

    /**
     * @param NavigationItemComponent $item
     * @param Company                 $company
     *
     * @return void
     */
    private function setNavigationStatus(NavigationItemComponent $item, Company $company): void
    {
        $dialog = DialogComponent::create()->setWidth(500);
        $action = VuexAction::create()->addDialog(
            $dialog->setModal(
                CardComponent::create()
                    ->setHeader(
                        CardHeaderComponent::create()
                            ->setTitle(trans('word.check.email'))
                            ->setCloseButton(VuexAction::create()->closeModal($dialog->getIdentifier()))
                    )
                    ->addBody(
                        ContentComponent::create()->setValue(trans('text.company.check.email'))
                    )
            )->setCloseAction(VuexAction::create()->closeModal($dialog->getIdentifier()))
        );


        if ($company->status !== CompanyStatusTypes::COMPLETED) {
            if ($company->owner->is(Auth::user())) {
                $item->setDescription(trans('word.new.new'))
                    ->setAction($action);

                return;
            }

            $item->setDescription(trans('word.company.inactive'));
        } else {
            $item->setRoute(VueRouteHelper::createCompany($company));
        }

        if ($company->pivot->status !== CompanyUserStatusTypes::ACCEPTED) {
            $item->setDescription($company->pivot->status->getTranslation())
                ->setAction($action);
        }
    }

    /**
     * @return NavbarComponent
     */
    private function createAdminNavigation(): NavbarComponent
    {
        return NavbarComponent::create()
            ->setNav()
            ->addItem(
                GroupNavigationComponent::create()
                    ->addNavigation(
                        NavigationItemComponent::create()
                            ->setTitle(trans('word.admin.admin'))
                            ->setHref(route('admin.view.dashboard'), TargetType::SELF)
                            ->setPrepend(IconComponent::create()->setType(IconType::FAS_USER_SHIELD))
                    )
            );
    }
}
