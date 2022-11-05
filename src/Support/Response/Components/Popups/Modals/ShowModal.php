<?php

namespace Support\Response\Components\Popups\Modals;

use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Enums\Component\Vuetify\VuetifyTransitionType;
use Support\Response\Actions\ChainAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\AbstractComponent;
use Support\Response\Components\Buttons\IconButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Icons\IconComponent;

class ShowModal extends AbstractModal
{
    private ?string $vuexNamespace;

    /**
     * ShowModal constructor.
     *
     * @param string|null $vuexNamespace
     */
    protected function __construct(?string $vuexNamespace = null)
    {
        $this->vuexNamespace = $vuexNamespace;

        parent::__construct();
    }

    /**
     * @return void
     */
    protected function initializeModal(): void
    {
        $this->modal->setPersistent();
    }

    /**
     * @return void
     */
    protected function initializeCard(): void
    {
        $this->card
            ->setHeaderButton(
                MultipleButtonComponent::create()
                    ->addButton(
                        IconButtonComponent::create()
                            ->setIcon(IconComponent::create()->setType(IconType::FAS_TIMES))
                            ->setAction(
                                ChainAction::create()
                                    ->addAction(
                                        VuexAction::create()->closeModal($this->modal->getIdentifier())
                                    )
                                    ->addActionIf(
                                        !\is_null($this->vuexNamespace),
                                        VuexAction::create()->commit("{$this->vuexNamespace}/resetShow"),
                                    )
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
            ->setTransition(VuetifyTransitionType::MODAL_BOTTOM);

        $this->card
            ->setLoadingBar()
            ->setRounded(false)
            ->setOutlined(false)
            ->addAdditionalBodyClass('mt-5')
            ->setColor(
                VuetifyColor::theme(VuetifyColor::DARK_BACKGROUND, VuetifyColor::NONE)
            )
            ->setHeaderColor(
                VuetifyColor::theme(VuetifyColor::DARK_HEADER, VuetifyColor::LIGHT_HEADER)
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
