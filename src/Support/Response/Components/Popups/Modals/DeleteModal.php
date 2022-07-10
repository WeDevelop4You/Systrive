<?php

namespace Support\Response\Components\Popups\Modals;

use Support\Enums\IconTypes;
use Support\Enums\Vuetify\VuetifyColors;
use Support\Response\Actions\AbstractAction;
use Support\Response\Actions\ChainAction;
use Support\Response\Actions\PopupModalAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\AbstractButtonComponent;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Buttons\IconButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Items\ItemTextComponent;

class DeleteModal extends AbstractModal
{
    /**
     * @var string|null
     */
    private ?string $vuexNamespace;

    /**
     * @var MultipleButtonComponent
     */
    private MultipleButtonComponent $footerButtons;

    /**
     * DeleteModal constructor.
     */
    protected function __construct(string $vuexNamespace)
    {
        $this->vuexNamespace = $vuexNamespace;

        parent::__construct();
    }

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
                            ->setIcon(IconComponent::create()->setType(IconTypes::FAS_TIMES))
                            ->setAction(PopupModalAction::create()->close($this->modal->getIdentifier()))
                    )
            );

        $this->setText(trans('text.delete'));
        $this->setTitle(trans('word.delete.delete'));

        $this->footerButtons = MultipleButtonComponent::create()
            ->addClass('gap-3');
    }

    /**
     * @param string $title
     *
     * @return DeleteModal
     */
    public function setTitle(string $title): DeleteModal
    {
        $this->card->setTitle($title);

        return $this;
    }

    /**
     * @param string $text
     *
     * @return DeleteModal
     */
    public function setText(string $text): DeleteModal
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
     * @return DeleteModal
     */
    private function addFooterButton(AbstractButtonComponent $button): DeleteModal
    {
        $this->footerButtons->addButton($button);

        return $this;
    }

    /**
     * @param AbstractAction $action
     * @param string|null    $title
     *
     * @return DeleteModal
     */
    public function addFooterForceDeleteButton(
        AbstractAction $action,
        ?string $title = null,
    ): DeleteModal {
        $chainActions = ChainAction::create()
            ->addAction(PopupModalAction::create()->close($this->modal->getIdentifier()));

        if ($this->hasVuexNamespace()) {
            $chainActions->addAction(VuexAction::create()->refreshTable($this->vuexNamespace));
        }

        $action->setOnSuccess($chainActions);

        return $this->addFooterButton(
            ButtonComponent::create()
                ->setType()
                ->setAction($action)
                ->setTitle($title ?: trans('word.delete.force'))
        );
    }

    /**
     * @param AbstractAction $action
     * @param string|null    $title
     *
     * @return DeleteModal
     */
    public function addFooterDeleteButton(
        AbstractAction $action,
        ?string $title = null,
    ): DeleteModal {
        $chainActions = ChainAction::create()
            ->addAction(PopupModalAction::create()->close($this->modal->getIdentifier()));

        if ($this->hasVuexNamespace()) {
            $chainActions->addAction(VuexAction::create()->refreshTable($this->vuexNamespace));
        }

        $action->setOnSuccess($chainActions);

        return $this->addFooterButton(
            ButtonComponent::create()
                ->setAction($action)
                ->setColor(VuetifyColors::ERROR)
                ->setTitle($title ?: trans('word.delete.delete'))
        );
    }

    /**
     * @return DeleteModal
     */
    public function addFooterCancelButton(): DeleteModal
    {
        return $this->addFooterButton(
            ButtonComponent::create()
                ->setTitle(trans('word.cancel.cancel'))
                ->setAction(PopupModalAction::create()->close($this->modal->getIdentifier()))
        );
    }

    /**
     * @return bool
     */
    private function hasVuexNamespace(): bool
    {
        return !is_null($this->vuexNamespace);
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
