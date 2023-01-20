<?php

namespace Support\Client\Components\Popups\Modals;

use Illuminate\Support\Arr;
use Support\Client\Actions\Action;
use Support\Client\Actions\ChainAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\AbstractButtonComponent;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Forms\AbstractFormComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Utils\VuexNamespace;

class FormModal extends AbstractModal
{
    /**
     * @var string|VuexNamespace|null
     */
    private readonly string|null|VuexNamespace $vuexNamespace;

    /**
     * @var CardHeaderComponent
     */
    private CardHeaderComponent $header;

    /**
     * @var MultipleButtonComponent|null
     */
    private ?MultipleButtonComponent $footer = null;

    /**
     * FormModal constructor.
     *
     * @param string|VuexNamespace|null $vuexNamespace
     * @param string|null               $dataTableVuexNamespace
     * @param bool                      $withoutDataTableRefresh
     */
    protected function __construct(
        string|null|VuexNamespace $vuexNamespace = null,
        private readonly ?string $dataTableVuexNamespace = null,
        private readonly bool $withoutDataTableRefresh = false
    ) {
        parent::__construct();

        $this->vuexNamespace = optional($vuexNamespace)->export() ?: $vuexNamespace;
    }

    protected function initializeModal(): void
    {
        $this->setWidth(700);
        $this->modal->setScrollable();
    }

    protected function initializeCard(): void
    {
        $this->header = CardHeaderComponent::create();
    }

    /**
     * @param string $title
     *
     * @return FormModal
     */
    public function setTitle(string $title): FormModal
    {
        $this->header->setTitle($title);

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

        $this->card->addBody($form)
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
            ->addAction(VuexAction::create()->closeModal($this->modal->getIdentifier()));

        if ($this->hasVuexNamespace()) {
            $action->addAction(VuexAction::create()->commit("{$this->vuexNamespace}/resetForm"));
        }

        $this->modal->setPersistent();
        $this->header->setCloseButton($action);

        return $this;
    }

    /**
     * @param AbstractButtonComponent $button
     *
     * @return FormModal
     */
    public function addFooter(AbstractButtonComponent $button): FormModal
    {
        if (\is_null($this->footer)) {
            $this->footer = MultipleButtonComponent::create()
                ->setClass('gap-3');
        }

        $this->footer->addButton($button);

        return $this;
    }

    public function addFooterCancelButton(?Action $action = null): FormModal
    {
        if (\is_null($action)) {
            $action = ChainAction::create()
                ->setActions([
                    VuexAction::create()->commit("{$this->vuexNamespace}/resetForm"),
                    VuexAction::create()->closeModal($this->modal->getIdentifier()),
                ]);
        } else {
            $action->setCloseModalOnSuccessAction($this->modal->getIdentifier());
        }

        return $this->addFooter(
            ButtonComponent::create()
                ->setAction($action)
                ->setTitle(trans('word.cancel.cancel'))
        );
    }

    /**
     * @param Action $action
     *
     * @return FormModal
     */
    public function addFooterSaveButton(Action $action): FormModal
    {
        $chainActions = ChainAction::create()
            ->addAction(VuexAction::create()->closeModal($this->modal->getIdentifier()));

        if ($this->hasVuexNamespace()) {
            $chainActions->addAction(
                VuexAction::create()->commit("{$this->vuexNamespace}/resetForm")
            )
            ->addActionIf(
                ! $this->withoutDataTableRefresh,
                VuexAction::create()->refreshTable($this->getDataTableVuexNamespace())
            );
        }

        $action->setOnSuccessAction($chainActions);

        return $this->addFooter(
            ButtonComponent::create()
                ->setColor()
                ->setAction($action)
                ->setTitle(trans('word.save.save'))
        );
    }

    /**
     * @return bool
     */
    private function hasVuexNamespace(): bool
    {
        return ! \is_null($this->vuexNamespace);
    }

    /**
     * @return string
     */
    private function getDataTableVuexNamespace(): string
    {
        return $this->dataTableVuexNamespace ?: \dirname($this->vuexNamespace).'/dataTable';
    }

    /**
     * @return array
     */
    public function export(): array
    {
        $this->card->setHeader($this->header);

        if ($this->footer instanceof MultipleButtonComponent) {
            $this->card->setFooter($this->footer);
        }

        return parent::export();
    }
}
