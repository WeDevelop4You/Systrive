<?php

namespace App\Account\Settings\Responses;

use Domain\Git\Enums\GitServiceTypes;
use Domain\Git\Mappings\GitAccountTableMap;
use Domain\Git\Models\GitAccount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\BreadcrumbAction;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\BtnComponentType;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Layouts\RowComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Misc\IconComponent;
use Support\Client\Components\Misc\Icons\IconWithTextComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Components\Overviews\ListItems\ListItemContentComponent;
use Support\Client\Response;
use Support\Enums\Component\Vuetify\VuetifyAlignType;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Enums\Component\Vuetify\VuetifyJustifyType;

class SettingsGitOverviewResponse extends AbstractResponse
{
    /**
     * @var Collection
     */
    private Collection $gitAccounts;

    protected function __construct()
    {
        $this->gitAccounts = Auth::user()->gitAccounts;
    }

    protected function handle(): Response
    {
        return Response::create()
            ->addAction(
                BreadcrumbAction::create()->add(trans('word.git'))
            )
            ->addComponent(
                RowComponent::create()
                    ->setNoGutters()
                    ->setClass('gap-3')
                    ->setCols($this->createGitCards())
            );
    }

    /**
     * @return array
     */
    private function createGitCards(): array
    {
        return Collection::make(GitServiceTypes::cases())
            ->map(function (GitServiceTypes $gitService) {
                return ColComponent::create()
                    ->setComponent(
                        CardComponent::create()
                            ->setHeader(
                                CardHeaderComponent::create()
                                    ->setTitle(ucfirst($gitService->value))
                            )
                            ->addBody(
                                RowComponent::create()
                                    ->setNoGutters()
                                    ->setAlign(VuetifyAlignType::CENTER)
                                    ->setJustify(VuetifyJustifyType::SPACE_BETWEEN)
                                    ->setCols([
                                        ColComponent::create()
                                            ->setDefaultCol('auto')
                                            ->setComponent(
                                                ListItemContentComponent::create()
                                                    ->setClass('mb-0')
                                                    ->setValue(trans('text.connect.git.account')),
                                            ),
                                        ColComponent::create()
                                            ->setDefaultCol('auto')
                                            ->setComponent($this->createButton($gitService)),
                                    ])
                            )
                    );
            })->toArray();
    }

    /**
     * @param GitServiceTypes $gitService
     *
     * @return BtnComponentType
     */
    private function createButton(GitServiceTypes $gitService): BtnComponentType
    {
        $account = $this->gitAccounts->firstWhere(GitAccountTableMap::COL_SERVICE, $gitService);

        if ($account instanceof GitAccount) {
            return BtnComponentType::create()
                ->setColor(VuetifyColor::ERROR)
                ->setIcon(IconComponent::create()->setLeftSide()->setType($gitService->icon()))
                ->setTitle(trans('word.disconnect.disconnect', ['username' => $account->username]))
                ->setAction(
                    RequestAction::create()->delete(
                        route('admin.git.services.disconnect', [
                            $gitService->value,
                        ])
                    )->setOnSuccessAction(
                        VuexAction::create()
                            ->dispatch(
                                'user/auth/settings/overview/component',
                                route('admin.account.settings.overview.page', 'git')
                            )
                    )
                );
        }

        return BtnComponentType::create()
            ->setColor()
            ->setHref(route('admin.git.login', $gitService->value))
            ->setIcon(IconComponent::create()->setLeftSide()->setType($gitService->icon()))
            ->setTitle(trans('word.connect.connect'));
    }
}
