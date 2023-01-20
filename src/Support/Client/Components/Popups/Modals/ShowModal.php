<?php

namespace Support\Client\Components\Popups\Modals;

use Support\Client\Actions\ChainAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Component;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Enums\Component\Vuetify\VuetifyTransitionType;

class ShowModal extends AbstractModal
{
    /**
     * @var string|null
     */
    private ?string $vuexNamespace;

    /**
     * @var CardHeaderComponent
     */
    private CardHeaderComponent $header;

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
        $this->header = CardHeaderComponent::create()->setCloseButton(
            ChainAction::create()
                ->addAction(
                    VuexAction::create()->closeModal($this->modal->getIdentifier())
                )
                ->addActionIf(
                    ! \is_null($this->vuexNamespace),
                    VuexAction::create()->commit("{$this->vuexNamespace}/resetShow"),
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
        $this->header->setTitle($title);

        return $this;
    }

    /**
     * @return ShowModal
     */
    public function setFullscreen(): ShowModal
    {
        $this->modal->setFullscreen()
            ->setHideOverlay()
            ->setNoClickAnimation()
            ->setTransition(VuetifyTransitionType::MODAL_BOTTOM);

        $this->card->setLoadingBar()
            ->setRounded(false)
            ->setOutlined(false)
            ->addAdditionalBodyClass('mt-5')
            ->setColor(
                VuetifyColor::theme(VuetifyColor::DARK_BACKGROUND, VuetifyColor::NONE)
            );

        $this->header->setColor(
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
     * @param array|Component[] $components
     *
     * @return ShowModal
     */
    public function setComponents(array $components): ShowModal
    {
        foreach ($components as $component) {
            if ($component instanceof Component) {
                $this->addComponent($component);
            }
        }

        return $this;
    }

    /**
     * @param Component $component
     *
     * @return ShowModal
     */
    public function addComponent(Component $component): ShowModal
    {
        $this->card->addBody($component);

        return $this;
    }

    public function export(): array
    {
        $this->card->setHeader($this->header);

        return parent::export();
    }
}
