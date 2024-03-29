<?php

namespace Support\Client\Components\Popups\Modals;

use Support\Client\Actions\Action;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\AbstractBtnComponent;
use Support\Client\Components\Buttons\BtnComponentType;
use Support\Client\Components\Layouts\WrapperComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Misc\ContentComponent;
use Support\Enums\Component\ModalCloseType;

class ConfirmModal extends AbstractModal
{
    /**
     * @var CardHeaderComponent
     */
    private CardHeaderComponent $header;

    /**
     * @var WrapperComponent
     */
    private WrapperComponent $footer;

    protected function initializeModal(): void
    {
        $this->modal
            ->setPersistent()
            ->setWidth(500);
    }

    protected function initializeCard(): void
    {
        $this->header = CardHeaderComponent::create()->setCloseButton(
            VuexAction::create()->closeModal($this->modal->getIdentifier())
        );

        $this->footer = WrapperComponent::create()->setClass('gap-3');
    }

    /**
     * @param string $title
     *
     * @return ConfirmModal
     */
    public function setTitle(string $title): ConfirmModal
    {
        $this->header->setTitle($title);

        return $this;
    }

    /**
     * @param string $text
     *
     * @return ConfirmModal
     */
    public function setText(string $text): ConfirmModal
    {
        $this->card
            ->addBody(
                ContentComponent::create()->setValue($text)
            );

        return $this;
    }

    /**
     * @param AbstractBtnComponent $button
     *
     * @return ConfirmModal
     */
    private function addFooter(AbstractBtnComponent $button): ConfirmModal
    {
        $this->footer->addComponent($button);

        return $this;
    }

    /**
     * @param Action         $action
     * @param string|null    $title
     * @param ModalCloseType $close
     *
     * @return ConfirmModal
     */
    public function addFooterCancelButton(
        Action $action,
        ?string $title = null,
        ModalCloseType $close = ModalCloseType::NEVER
    ): ConfirmModal {
        if (ModalCloseType::isSuccess($close)) {
            $action->setCloseModalOnSuccessAction($this->modal->getIdentifier());
        }

        if (ModalCloseType::isFail($close)) {
            $action->setCloseModalOnFailAction($this->modal->getIdentifier());
        }

        return $this->addFooter(
            BtnComponentType::create()
                ->setAction($action)
                ->setTitle($title ?: trans('word.cancel.cancel'))
        );
    }

    /**
     * @param Action         $action
     * @param string|null    $title
     * @param ModalCloseType $close
     *
     * @return ConfirmModal
     */
    public function addFooterSubmitButton(
        Action $action,
        ?string $title = null,
        ModalCloseType $close = ModalCloseType::NEVER
    ): ConfirmModal {
        if (ModalCloseType::isSuccess($close)) {
            $action->setCloseModalOnSuccessAction($this->modal->getIdentifier());
        }

        if (ModalCloseType::isFail($close)) {
            $action->setCloseModalOnFailAction($this->modal->getIdentifier());
        }

        return $this->addFooter(
            BtnComponentType::create()
                ->setColor()
                ->setAction($action)
                ->setTitle($title ?: trans('word.accept.accept'))
        );
    }

    /**
     * @return array
     */
    public function export(): array
    {
        $this->card->setHeader($this->header)->setFooter($this->footer);

        return parent::export();
    }
}
