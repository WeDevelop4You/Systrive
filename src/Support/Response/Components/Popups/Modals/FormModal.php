<?php

namespace Support\Response\Components\Popups\Modals;

use Illuminate\Support\Arr;
use Support\Enums\IconTypes;
use Support\Response\Actions\AbstractAction;
use Support\Response\Actions\ChainAction;
use Support\Response\Actions\PopupModalAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\AbstractButtonComponent;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Buttons\IconButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Forms\AbstractFormComponent;
use Support\Response\Components\Icons\IconComponent;

class FormModal extends AbstractModal
{
    /**
     * @var string|null
     */
    private ?string $vuexNamespace;

    /**
     * @var MultipleButtonComponent|null
     */
    private ?MultipleButtonComponent $footerButtons = null;

    /**
     * FormModal constructor.
     */
    protected function __construct(string $vuexNamespace)
    {
        $this->vuexNamespace = $vuexNamespace;

        parent::__construct();
    }

    protected function initializeModal(): void
    {
        $this->setWidth(700);
    }

    protected function initializeCard(): void
    {
        //
    }

    /**
     * @param string $title
     *
     * @return FormModal
     */
    public function setTitle(string $title): FormModal
    {
        $this->card->setTitle($title);

        return $this;
    }

    /**
     * @param AbstractFormComponent $form
     * @param array|string          $classes
     *
     * @return FormModal
     */
    public function setForm(AbstractFormComponent $form, string|array $classes = 'px-4'): FormModal
    {
        if ($this->hasVuexNamespace()) {
            $form->setVuexNamespace($this->vuexNamespace);
        }

        $this->card
            ->addBody($form)
            ->setAdditionalBodyClasses(Arr::wrap($classes));

        return $this;
    }

    /**
     * @param int|string $width
     *
     * @return FormModal
     */
    public function setWidth(string|int $width): FormModal
    {
        $this->modal->setWidth($width);

        return $this;
    }

    /**
     * @return FormModal
     */
    public function setPersistent(): FormModal
    {
        $action = ChainAction::create()
            ->addAction(PopupModalAction::create()->close($this->modal->getIdentifier()));

        if ($this->hasVuexNamespace()) {
            $action->addAction(VuexAction::create()->commit("{$this->vuexNamespace}/resetForm"));
        }

        $this->modal->setPersistent();

        $this->card
            ->setHeaderButton(
                MultipleButtonComponent::create()
                    ->addButton(
                        IconButtonComponent::create()
                            ->setIcon(IconComponent::create()->setType(IconTypes::FAS_TIMES))
                            ->setAction($action)
                    )
            );

        return $this;
    }

    /**
     * @param AbstractButtonComponent $button
     *
     * @return FormModal
     */
    public function addFooterButton(AbstractButtonComponent $button): FormModal
    {
        $this->setFooterButton();

        $this->footerButtons->addButton($button);

        return $this;
    }

    public function addFooterCancelButton(?AbstractAction $action = null): FormModal
    {
        if (is_null($action)) {
            $action = ChainAction::create()
                ->setActions([
                    VuexAction::create()->commit("{$this->vuexNamespace}/resetForm"),
                    PopupModalAction::create()->close($this->modal->getIdentifier()),
                ]);
        } else {
            $action->setOnSuccessAsClosePopupModal($this->modal->getIdentifier());
        }

        return $this->addFooterButton(
            ButtonComponent::create()
                ->setAction($action)
                ->setTitle(trans('word.cancel.cancel'))
        );
    }

    /**
     * @param AbstractAction $action
     *
     * @return FormModal
     */
    public function addFooterSaveButton(AbstractAction $action): FormModal
    {
        $chainActions = ChainAction::create()
            ->addAction(PopupModalAction::create()->close($this->modal->getIdentifier()));

        if ($this->hasVuexNamespace()) {
            $chainActions->setActions([
                VuexAction::create()->commit("{$this->vuexNamespace}/resetForm"),

// TODO Fix this
//                VuexAction::create()->refreshTable($this->vuexNamespace),
            ]);
        }

        $action->setOnSuccess($chainActions);

        return $this->addFooterButton(
            ButtonComponent::create()
                ->setColor()
                ->setAction($action)
                ->setTitle(trans('word.save.save'))
        );
    }

    private function setFooterButton(): void
    {
        if (is_null($this->footerButtons)) {
            $this->footerButtons = MultipleButtonComponent::create()
                ->addClass('gap-3');
        }
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
        if ($this->footerButtons instanceof MultipleButtonComponent) {
            $this->card->setFooterButton($this->footerButtons);
        }

        return parent::export();
    }
}
