<?php

namespace App\Admin\Account\Responses;

use Domain\Git\Enums\GitServiceTypes;
use Domain\Git\Mappings\GitAccountTableMap;
use Domain\Git\Models\GitAccount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Support\Abstracts\AbstractResponse;
use Support\Enums\Vuetify\VuetifyAlignTypes;
use Support\Enums\Vuetify\VuetifyColors;
use Support\Enums\Vuetify\VuetifyJustifyTypes;
use Support\Response\Actions\BreadcrumbAction;
use Support\Response\Actions\RequestAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Icons\TextIconComponent;
use Support\Response\Components\Items\ItemTextComponent;
use Support\Response\Components\Layouts\ColComponent;
use Support\Response\Components\Layouts\RowComponent;
use Support\Response\Components\Overviews\CardComponent;
use Support\Response\Response;

class AccountSettingsGitOverviewResponse extends AbstractResponse
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
                    ->addClass('gap-3')
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
                            ->setTitle(ucfirst($gitService->value))
                            ->addBody(
                                RowComponent::create()
                                    ->setNoGutters()
                                    ->setAlign(VuetifyAlignTypes::CENTER)
                                    ->setJustify(VuetifyJustifyTypes::SPACE_BETWEEN)
                                    ->setCols([
                                        ColComponent::create()
                                            ->setDefaultCol('auto')
                                            ->setComponent(
                                                ItemTextComponent::create()
                                                    ->addClass('mb-0')
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
     * @return ButtonComponent
     */
    private function createButton(GitServiceTypes $gitService): ButtonComponent
    {
        $account = $this->gitAccounts->firstWhere(GitAccountTableMap::SERVICE, $gitService);

        if ($account instanceof GitAccount) {
            return ButtonComponent::create()
                ->setColor(VuetifyColors::ERROR)
                ->setTitleWithIcon(
                    TextIconComponent::create()
                        ->setLeftSide()
                        ->setText(trans('word.disconnect.disconnect', ['username' => $account->username]))
                        ->setType($gitService->icon())
                )
                ->setAction(
                    RequestAction::create()->delete(
                        route('admin.git.services.disconnect', [
                            $gitService->value,
                        ])
                    )->setOnSuccess(
                        VuexAction::create()
                            ->dispatch(
                                'user/auth/settings/overview/component',
                                route('admin.account.settings.overview.page', 'git')
                            )
                    )
                );
        }

        return ButtonComponent::create()
            ->setColor()
            ->setHref(route('admin.git.login', $gitService->value))
            ->setTitleWithIcon(
                TextIconComponent::create()
                    ->setLeftSide()
                    ->setText(trans('word.connect.connect'))
                    ->setType($gitService->icon())
            );
    }
}
