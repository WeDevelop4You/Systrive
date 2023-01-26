<?php

namespace Support\Client\Components\Forms\Inputs;

use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Misc\ImageCropperComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Components\Popups\DialogComponent;

class ImageInputComponent extends AbstractFileInputComponent
{
    /**
     * @var int
     */
    private int $width;

    /**
     * @var int
     */
    private int $height;

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'ImageInputComponent';
    }

    /**
     * {@inheritDoc}
     */
    protected function getPlaceholderText(bool $multiple): string
    {
        return $multiple ? trans('text.select.images') : trans('text.select.image');
    }

    public function setAspectRadio(int $width, int $height): static
    {
        $this->width = $width;
        $this->height = $height;

        return $this;
    }

    /**
     * @return string
     */
    private function getVuexCropperNamespace(): string
    {
        return "{$this->getData('vuexNamespace')}/{$this->getData('key')}";
    }

    /**
     * @return DialogComponent
     */
    private function createModal(): DialogComponent
    {
        $vuexCropperNamespace = $this->getVuexCropperNamespace();

        return DialogComponent::create()
            ->setPersistent()
            ->setWidth('100%')
            ->setAttribute('eager', true)
            ->setData('show', false)
            ->setModal(
                CardComponent::create()
                    ->setHeader(
                        CardHeaderComponent::create()
                            ->setTitle(trans('word.crop.image'))
                    )
                    ->addBody(
                        ImageCropperComponent::create()
                            ->setVuexNamespace($vuexCropperNamespace)
                            ->setAspectRatio($this->width, $this->height)
                    )
                    ->setFooter(
                        MultipleButtonComponent::create()
                            ->setClass('gap-3')
                            ->setButtons([
                                ButtonComponent::create()
                                    ->setType()
                                    ->setTitle(trans('word.cancel.cancel'))
                                    ->setAction(
                                        VuexAction::create()->dispatch(
                                            "{$vuexCropperNamespace}/cancel"
                                        )
                                    ),
                                ButtonComponent::create()
                                    ->setColor()
                                    ->setTitle(trans('word.save.save'))
                                    ->setAction(
                                        VuexAction::create()->dispatch(
                                            "{$vuexCropperNamespace}/save"
                                        )
                                    ),
                            ])
                    )
            );
    }

    /**
     * @return array
     */
    public function export(): array
    {
        $this->setData('dialog', $this->createModal()->export());
        $this->setData('vuexCropperNamespace', $this->getVuexCropperNamespace());

        return parent::export();
    }
}
