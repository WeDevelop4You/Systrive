<?php

namespace Support\Response\Components\Popups\Modals;

use Support\Enums\Component\IconType;
use Support\Enums\Component\ModalCloseType;
use Support\Response\Actions\AbstractAction;
use Support\Response\Actions\PopupModalAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\AbstractButtonComponent;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Buttons\IconButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Items\ItemTextComponent;

class ConfirmModal extends AbstractModal
{
    /**
     * @var MultipleButtonComponent
     */
    private MultipleButtonComponent $footerButtons;

    protected function initializeModal(): void
    {
        $this->modal
            ->setPersistent()
            ->setWidth(500);
    }

    protected function initializeCard(): void
    {
        $this->card
            ->setHeaderButton(
                MultipleButtonComponent::create()
                    ->addButton(
                        IconButtonComponent::create()
                            ->setIcon(IconComponent::create()->setType(IconType::FAS_TIMES))
                            ->setAction(VuexAction::create()->closeModal($this->modal->getIdentifier()))
                    )
            );

        $this->footerButtons = MultipleButtonComponent::create()
            ->addClass('gap-3');
    }

    /**
     * @param string $title
     *
     * @return ConfirmModal
     */
    public function setTitle(string $title): ConfirmModal
    {
        $this->card->setTitle($title);

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
                ItemTextComponent::create()
                    ->setValue($text)
            );

        return $this;
    }

    /**
     * @param AbstractButtonComponent $button
     *
     * @return ConfirmModal
     */
    private function addFooterButton(AbstractButtonComponent $button): ConfirmModal
    {
        $this->footerButtons->addButton($button);

        return $this;
    }

    /**
     * @param AbstractAction $action
     * @param string|null    $title
     * @param ModalCloseType $close
     *
     * @return ConfirmModal
     */
    public function addFooterCancelButton(
        AbstractAction $action,
        ?string        $title = null,
        ModalCloseType $close = ModalCloseType::NEVER
    ): ConfirmModal {
        if (ModalCloseType::isSuccess($close)) {
            $action->setCloseModalOnSuccessAction($this->modal->getIdentifier());
        }

        if (ModalCloseType::isFail($close)) {
            $action->setCloseModalOnFailAction($this->modal->getIdentifier());
        }

        return $this->addFooterButton(
            ButtonComponent::create()
                ->setAction($action)
                ->setTitle($title ?: trans('word.cancel.cancel'))
        );
    }

    /**
     * @param AbstractAction $action
     * @param string|null    $title
     * @param ModalCloseType $close
     *
     * @return ConfirmModal
     */
    public function addFooterSubmitButton(
        AbstractAction $action,
        ?string        $title = null,
        ModalCloseType $close = ModalCloseType::NEVER
    ): ConfirmModal {
        if (ModalCloseType::isSuccess($close)) {
            $action->setCloseModalOnSuccessAction($this->modal->getIdentifier());
        }

        if (ModalCloseType::isFail($close)) {
            $action->setCloseModalOnFailAction($this->modal->getIdentifier());
        }

        return $this->addFooterButton(
            ButtonComponent::create()
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
        $this->card
            ->setFooterButton($this->footerButtons);

        return parent::export();
    }
}
