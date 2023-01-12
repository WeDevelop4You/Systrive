<?php

namespace Support\Client\Components\Misc;

use Support\Client\Actions\Action;
use Support\Client\Components\Attributes\ComponentWithClasses;
use Support\Client\Components\Buttons\IconButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Component;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\Components\Utils\ThemeComponent;
use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;

class CardHeaderComponent extends Component
{
    use ComponentWithClasses;

    /**
     * CardHeaderComponent constructor.
     */
    protected function __construct()
    {
        parent::__construct();

        $this->setColor(VuetifyColor::TRANSPARENT);
    }

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'CardHeaderComponent';
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): static
    {
        return $this->setContent('title', $title);
    }

    /**
     * @param MultipleButtonComponent $button
     *
     * @return $this
     */
    public function setButton(MultipleButtonComponent $button): static
    {
        return $this->setData('button', $button->export());
    }

    /**
     * @param Action $action
     *
     * @return $this
     */
    public function setCloseButton(Action $action): static
    {
        return $this->setButton(
            MultipleButtonComponent::create()
                ->addButton(
                    IconButtonComponent::create()
                        ->setIcon(IconComponent::create()->setType(IconType::FAS_TIMES))
                        ->setAction($action)
                )
        );
    }

    /**
     * @param ThemeComponent|VuetifyColor $color
     *
     * @return $this
     */
    public function setColor(VuetifyColor|ThemeComponent $color): static
    {
        $value = optional($color)->value ?: $color->export();

        return $this->setAttribute('color', $value);
    }
}
