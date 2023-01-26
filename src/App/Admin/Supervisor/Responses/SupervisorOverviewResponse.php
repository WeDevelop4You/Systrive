<?php

namespace App\Admin\Supervisor\Responses;

use Illuminate\Support\Collection;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\IconButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Layouts\RowComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Components\Overviews\ListComponent;
use Support\Client\Components\Overviews\ListItems\ListItemBadgeComponent;
use Support\Client\Components\Overviews\ListItems\ListItemContentComponent;
use Support\Client\Components\Overviews\ListItems\ListItemUpTimerComponent;
use Support\Client\Components\Utils\TooltipComponent;
use Support\Client\Response;
use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Services\Supervisor;

class SupervisorOverviewResponse extends AbstractResponse
{
    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                RowComponent::create()
                    ->addCol($this->createTopBar())
                    ->setCols($this->createBody())
            );
    }

    /**
     * @return ColComponent
     */
    private function createTopBar(): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                CardComponent::create()->setHeader(
                    CardHeaderComponent::create()
                        ->setTitle(trans('Supervisors'))
                        ->setButton(
                            MultipleButtonComponent::create()
                                ->setButtons([
                                    IconButtonComponent::create()
                                        ->setIcon(IconComponent::create()->setType(IconType::FAS_PLAY))
                                        ->setAction(
                                            RequestAction::create()
                                                ->post(route('admin.supervisor.process.start'))
                                                ->setOnSuccessAction($this->getOverviewAction())
                                        )
                                        ->setTooltip(
                                            TooltipComponent::create()
                                                ->setTop()
                                                ->setText(trans('word.supervisor.start.all'))
                                        ),
                                    IconButtonComponent::create()
                                        ->setIcon(IconComponent::create()->setType(IconType::FAS_STOP))
                                        ->setAction(
                                            RequestAction::create()
                                                ->post(route('admin.supervisor.process.stop'))
                                                ->setOnSuccessAction($this->getOverviewAction())
                                        )
                                        ->setTooltip(
                                            TooltipComponent::create()
                                                ->setTop()
                                                ->setText(trans('word.supervisor.stop.all'))
                                        ),
                                    IconButtonComponent::create()
                                        ->setIcon(IconComponent::create()->setType(IconType::FAS_COG))
                                        ->setAction(
                                            VuexAction::create()->dispatch(
                                                'supervisor/show',
                                                route('admin.supervisor.show')
                                            )
                                        )
                                        ->setTooltip(
                                            TooltipComponent::create()
                                                ->setTop()
                                                ->setText(trans('word.settings'))
                                        ),
                                ])
                        )
                )
            );
    }

    private function createBody(): array
    {
        $processes = Supervisor::api()->getAllProcessInfo();

        return Collection::make($processes)->map(function ($process) {
            return ColComponent::create()
                ->setComponent($this->createCard((object) $process))
                ->setMdCol(3);
        })->toArray();
    }

    /**
     * @param object $process
     *
     * @return CardComponent
     */
    private function createCard(object $process): CardComponent
    {
        return CardComponent::create()
            ->setHeader(
                CardHeaderComponent::create()
                    ->setTitle($process->name)
                    ->setButton(
                        MultipleButtonComponent::create()
                            ->setButtons($this->createActions($process))
                    )
            )
            ->addBody(
                ListComponent::create()->addItems($this->createList($process))
            )
            ->addAdditionalBodyClass('pa-0');
    }

    /**
     * @param object $process
     *
     * @return array
     */
    private function createList(object $process): array
    {
        $color = match ($process->state) {
            20 => VuetifyColor::SUCCESS,
            10, 30, 40 => VuetifyColor::WARNING,
            default => VuetifyColor::ERROR
        };

        $list = [
            ListItemBadgeComponent::create()
                ->setOutlined()
                ->setColor($color)
                ->setLabel(trans('word.status'))
                ->setValue(Supervisor::getProcessState($process->state)),
            ListItemContentComponent::create()
                ->setLabel(trans('word.group'))
                ->setValue($process->group),
        ];

        if ($process->state === 20) {
            $list[] = ListItemUpTimerComponent::create()
                ->setLabel(trans('word.uptime'))
                ->setValue($process->start);
        }

        if (!empty($process->spawnerr)) {
            $list[] = ListItemContentComponent::create()
                ->setLabel(trans('word.error.description'))
                ->setValue($process->spawnerr);
        }

        if ($process->pid !== 0) {
            $list[] = ListItemContentComponent::create()
                ->setLabel(trans('word.pid'))
                ->setValue($process->pid);
        }

        return $list;
    }

    /**
     * @param object $process
     *
     * @return array
     */
    private function createActions(object $process): array
    {
        if (Supervisor::inProcessRunning($process->state)) {
            return [
                IconButtonComponent::create()
                    ->setIcon(IconComponent::create()->setType(IconType::FAS_SYNC))
                    ->setAction(
                        RequestAction::create()
                            ->post(route('admin.supervisor.process.restart', [
                                $process->name,
                            ]))
                            ->setOnSuccessAction($this->getOverviewAction())
                    )
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setTop()
                            ->setText(trans('word.supervisor.restart'))
                    ),
                IconButtonComponent::create()
                    ->setIcon(IconComponent::create()->setType(IconType::FAS_STOP))
                    ->setAction(
                        RequestAction::create()
                            ->post(route('admin.supervisor.process.stop', [
                                $process->name,
                            ]))
                            ->setOnSuccessAction($this->getOverviewAction())
                    )
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setTop()
                            ->setText(trans('word.supervisor.stop.stop'))
                    ),
            ];
        }

        return [
            IconButtonComponent::create()
                ->setIcon(IconComponent::create()->setType(IconType::FAS_PLAY))
                ->setAction(
                    RequestAction::create()
                        ->post(route('admin.supervisor.process.start', [
                            $process->name,
                        ]))
                        ->setOnSuccessAction($this->getOverviewAction())
                )
                ->setTooltip(
                    TooltipComponent::create()
                        ->setTop()
                        ->setText(trans('word.supervisor.start.start'))
                ),
        ];
    }

    /**
     * @return VuexAction
     */
    private function getOverviewAction(): VuexAction
    {
        return VuexAction::create()
            ->dispatch(
                'supervisor/overview/component',
                route('admin.supervisor.overview')
            );
    }
}
