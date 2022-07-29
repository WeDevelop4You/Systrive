<?php

namespace Support\Response\Components\Popups\Modals;

use Support\Enums\Component\IconTypes;
use Support\Enums\Component\Vuetify\VuetifyColors;
use Support\Enums\Component\Vuetify\VuetifyTransitionTypes;
use Support\Response\Actions\ChainAction;
use Support\Response\Actions\PopupModalAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\AbstractComponent;
use Support\Response\Components\Buttons\IconButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Icons\IconComponent;

class ShowModal extends AbstractModal
{
    private ?string $vuexNamespace;

    protected function __construct(string $vuexNamespace)
    {
        $this->vuexNamespace = $vuexNamespace;

        parent::__construct();
    }

    protected function initializeModal(): void
    {
        $this->modal->setPersistent();
    }

    protected function initializeCard(): void
    {
        $this->card
            ->setHeaderButton(
                MultipleButtonComponent::create()
                    ->addButton(
                        IconButtonComponent::create()
                            ->setIcon(IconComponent::create()->setType(IconTypes::FAS_TIMES))
                            ->setAction(
                                ChainAction::create()
                                    ->setActions([
                                        PopupModalAction::create()->close($this->modal->getIdentifier()),
                                        VuexAction::create()->commit("{$this->vuexNamespace}/resetShow"),
                                    ])
                            )
                    )
            );
    }

    /**
     * @param string $title
     *
     * @return ShowModal
     */
    public function setTitle(string $title): ShowModal
    {
        $this->card->setTitle($title);

        return $this;
    }

    /**
     * @return ShowModal
     */
    public function setFullscreen(): ShowModal
    {
        $this->modal
            ->setFullscreen()
            ->setHideOverlay()
            ->setNoClickAnimation()
            ->setTransition(VuetifyTransitionTypes::MODAL_BOTTOM);

        $this->card
            ->setLoadingBar()
            ->setRounded(false)
            ->setOutlined(false)
            ->addAdditionalBodyClass('my-5')
            ->setColor(
                VuetifyColors::theme(VuetifyColors::DARK_BACKGROUND, VuetifyColors::NONE)
            )
            ->setHeaderColor(
                VuetifyColors::theme(VuetifyColors::DARK_HEADER, VuetifyColors::LIGHT_HEADER)
            );

        return $this;
    }

    /**
     * @param int $width
     *
     * @return ShowModal
     */
    public function setWidth(int $width): ShowModal
    {
        $this->modal->setWidth($width);

        return $this;
    }

    /**
     * @param AbstractComponent[]|array $components
     *
     * @return ShowModal
     */
    public function setComponents(array $components): ShowModal
    {
        foreach ($components as $component) {
            if ($component instanceof AbstractComponent) {
                $this->addComponent($component);
            }
        }

        return $this;
    }

    /**
     * @param AbstractComponent $component
     *
     * @return ShowModal
     */
    public function addComponent(AbstractComponent $component): ShowModal
    {
        $this->card->addBody($component);

        return $this;
    }
}