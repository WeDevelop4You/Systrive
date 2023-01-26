<?php

namespace Support\Client\Components\Popups\Modals;

use Support\Client\Actions\Action;
use Support\Client\Actions\ChainAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\AbstractButtonComponent;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Overviews\ListItems\ListItemContentComponent;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Utils\VuexNamespace;

class DeleteModal extends AbstractModal
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
     * @var MultipleButtonComponent
     */
    private MultipleButtonComponent $footer;

    /**
     * DeleteModal constructor.
     *
     * @param string|VuexNamespace|null $vuexNamespace
     * @param bool                      $deleted
     */
    protected function __construct(
        string|null|VuexNamespace $vuexNamespace = null,
        private readonly bool $deleted = false,
    ) {
        parent::__construct();

        $this->vuexNamespace = optional($vuexNamespace)->export() ?: $vuexNamespace;
    }

    protected function initializeModal(): void
    {
        $this->modal
            ->setPersistent()
            ->setWidth(500);
    }

    protected function initializeCard(): void
    {
        $this->setText(trans('text.delete'));

        $this->header = CardHeaderComponent::create()
            ->setTitle(trans('word.delete.delete'))
            ->setCloseButton(VuexAction::create()->closeModal($this->modal->getIdentifier()));

        $this->footer = MultipleButtonComponent::create()->setClass('gap-3');
    }

    /**
     * @param string $title
     *
     * @return DeleteModal
     */
    public function setTitle(string $title): DeleteModal
    {
        $this->header->setTitle($title);

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
                ListItemContentComponent::create()
                    ->setValue($text)
            );

        return $this;
    }

    /**
     * @param AbstractButtonComponent $button
     *
     * @return DeleteModal
     */
    private function addFooter(AbstractButtonComponent $button): DeleteModal
    {
        $this->footer->addButton($button);

        return $this;
    }

    /**
     * @param Action      $action
     * @param string|null $title
     *
     * @return DeleteModal
     */
    public function addFooterForceDeleteButton(Action $action, ?string $title = null): DeleteModal
    {
        $action->setOnSuccessAction($this->createOnSuccessAction());

        $button = ButtonComponent::create()
            ->setAction($action)
            ->setTitle($title ?: trans('word.delete.force'));

        $this->deleted ? $button->setColor(VuetifyColor::ERROR) : $button->setType();

        return $this->addFooter($button);
    }

    /**
     * @param Action      $action
     * @param string|null $title
     * @param bool        $isDeleted
     *
     * @return DeleteModal
     */
    public function addFooterDeleteButton(Action $action, ?string $title = null, $isDeleted = false): DeleteModal
    {
        if ($this->deleted) {
            return $this;
        }

        $action->setOnSuccessAction($this->createOnSuccessAction());

        return $this->addFooter(
            ButtonComponent::create()
                ->setAction($action)
                ->setColor(VuetifyColor::ERROR)
                ->setTitle($title ?: trans('word.delete.delete'))
        );
    }

    /**
     * @return DeleteModal
     */
    public function addFooterCancelButton(): DeleteModal
    {
        return $this->addFooter(
            ButtonComponent::create()
                ->setTitle(trans('word.cancel.cancel'))
                ->setAction(VuexAction::create()->closeModal($this->modal->getIdentifier()))
        );
    }

    /**
     * @return ChainAction
     */
    private function createOnSuccessAction(): ChainAction
    {
        return ChainAction::create()
            ->addAction(VuexAction::create()->closeModal($this->modal->getIdentifier()))
            ->addActionIf(
                $this->hasVuexNamespace(),
                VuexAction::create()->refreshTable($this->vuexNamespace ?? '')
            );
    }

    /**
     * @return bool
     */
    private function hasVuexNamespace(): bool
    {
        return !\is_null($this->vuexNamespace);
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
