<?php

namespace App\Admin\Supervisor\Responses;

use Illuminate\Support\Collection;
use Support\Abstracts\AbstractResponse;
use Support\Enums\IconTypes;
use Support\Enums\Vuetify\VuetifyColors;
use Support\Response\Actions\RequestAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\IconButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Items\ItemBadgeComponent;
use Support\Response\Components\Items\ItemTextComponent;
use Support\Response\Components\Items\ItemUpTimerComponent;
use Support\Response\Components\Layouts\ColComponent;
use Support\Response\Components\Layouts\RowComponent;
use Support\Response\Components\Overviews\CardComponent;
use Support\Response\Components\Overviews\ListComponent;
use Support\Response\Components\Utils\TooltipComponent;
use Support\Response\Response;
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
                CardComponent::create()
                    ->setTitle(trans('Supervisors'))
                    ->setHeaderButton(
                        MultipleButtonComponent::create()
                            ->setButtons([
                                IconButtonComponent::create()
                                    ->setIcon(IconComponent::create()->setType(IconTypes::FAS_PLAY))
                                    ->setAction(
                                        RequestAction::create()
                                            ->post(route('admin.admin.supervisor.process.start'))
                                            ->setOnSuccess($this->getOverviewAction())
                                    )
                                    ->setTooltip(
                                        TooltipComponent::create()
                                            ->setTop()
                                            ->setText(trans('word.supervisor.start.all'))
                                    ),
                                IconButtonComponent::create()
                                    ->setIcon(IconComponent::create()->setType(IconTypes::FAS_STOP))
                                    ->setAction(
                                        RequestAction::create()
                                            ->post(route('admin.admin.supervisor.process.stop'))
                                            ->setOnSuccess($this->getOverviewAction())
                                    )
                                    ->setTooltip(
                                        TooltipComponent::create()
                                            ->setTop()
                                            ->setText(trans('word.supervisor.stop.all'))
                                    ),
                                IconButtonComponent::create()
                                    ->setIcon(IconComponent::create()->setType(IconTypes::FAS_COG))
                                    ->setAction(
                                        VuexAction::create()->dispatch(
                                            'supervisor/show',
                                            route('admin.admin.supervisor.show')
                                        )
                                    )
                                    ->setTooltip(
                                        TooltipComponent::create()
                                            ->setTop()
                                            ->setText(trans('word.settings'))
                                    ),
                            ])
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
            ->setTitle($process->name)
            ->setHeaderButton(
                MultipleButtonComponent::create()
                    ->setButtons($this->createActions($process))
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
            20 => VuetifyColors::SUCCESS,
            10, 30, 40 => VuetifyColors::WARNING,
            default => VuetifyColors::ERROR
        };

        $list = [
            ItemBadgeComponent::create()
                ->setOutlined()
                ->setColor($color)
                ->setLabel(trans('word.status'))
                ->setValue(Supervisor::getProcessState($process->state)),
            ItemTextComponent::create()
                ->setLabel(trans('word.group'))
                ->setValue($process->group),
        ];

        if ($process->state === 20) {
            $list[] = ItemUpTimerComponent::create()
                ->setLabel(trans('word.uptime'))
                ->setValue($process->start);
        }

        if (!empty($process->spawnerr)) {
            $list[] = ItemTextComponent::create()
                ->setLabel(trans('word.error.description'))
                ->setValue($process->spawnerr);
        }

        if ($process->pid !== 0) {
            $list[] = ItemTextComponent::create()
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
                    ->setIcon(IconComponent::create()->setType(IconTypes::FAS_SYNC))
                    ->setAction(
                        RequestAction::create()
                            ->post(route('admin.admin.supervisor.process.restart', [
                                $process->name,
                            ]))
                            ->setOnSuccess($this->getOverviewAction())
                    )
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setTop()
                            ->setText(trans('word.supervisor.restart'))
                    ),
                IconButtonComponent::create()
                    ->setIcon(IconComponent::create()->setType(IconTypes::FAS_STOP))
                    ->setAction(
                        RequestAction::create()
                            ->post(route('admin.admin.supervisor.process.stop', [
                                $process->name,
                            ]))
                            ->setOnSuccess($this->getOverviewAction())
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
                ->setIcon(IconComponent::create()->setType(IconTypes::FAS_PLAY))
                ->setAction(
                    RequestAction::create()
                        ->post(route('admin.admin.supervisor.process.start', [
                            $process->name,
                        ]))
                        ->setOnSuccess($this->getOverviewAction())
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
                route('admin.admin.supervisor.overview')
            );
    }
}
