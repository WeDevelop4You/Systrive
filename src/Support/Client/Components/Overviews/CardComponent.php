<?php

namespace Support\Client\Components\Overviews;

use Support\Client\Components\Attributes\ComponentWithIfStatement;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Component;
use Support\Client\Components\Types\ModalComponentType;
use Support\Client\Components\Utils\ThemeComponent;
use Support\Enums\Component\Vuetify\VuetifyColor;

/**
 * @method setBodyIf(bool $condition, array $components)
 */
class CardComponent extends Component implements ModalComponentType
{
    use ComponentWithIfStatement;

    protected function __construct()
    {
        parent::__construct();

        $this->setRounded();
        $this->setOutlined();
        $this->setHasBody(false);
        $this->setHasFooter(false);
        $this->setHasHeader(false);
        $this->setHasSubBody(false);
    }

    protected function getComponentName(): string
    {
        return 'CardComponent';
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setRounded(bool $value = true): static
    {
        return $this->setAttribute('rounded', $value ? 'lg' : false);
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setOutlined(bool $value = true): static
    {
        return $this->setAttribute('outlined', $value);
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setWidth(int $value): static
    {
        return $this->setAttribute('width', $value);
    }

    /**
     * @param ThemeComponent|VuetifyColor $color
     *
     * @return $this
     */
    public function setColor(VuetifyColor|ThemeComponent $color): static
    {
        $value = optional($color)->export() ?: $color->value;

        return $this->setAttribute('color', $value);
    }

    /**
     * @return $this
     */
    public function setLoadingBar(): static
    {
        return $this->setData('hasLoadingBar', true);
    }

    /**
     * @param Component $component
     *
     * @return $this
     */
    public function setHeader(Component $component): static
    {
        return $this->setData('header', $component->export())->setHasHeader();
    }

    /**
     * @param Component $component
     *
     * @return $this
     */
    public function setSubBody(Component $component): static
    {
        return $this->setData('subBody', $component->export())->setHasSubBody();
    }

    /**
     * @param array|Component[] $components
     *
     * @return $this
     */
    public function setBody(array $components): static
    {
        foreach ($components as $component) {
            if ($component instanceof Component) {
                $this->addBody($component);
            }
        }

        return $this;
    }

    /**
     * @param Component $component
     *
     * @return $this
     */
    public function addBody(Component $component): static
    {
        return $this->setData('body', $component->export(), true)->setHasBody();
    }

    /**
     * @param MultipleButtonComponent $button
     *
     * @return $this
     */
    public function setFooter(MultipleButtonComponent $button): static
    {
        return $this->setData('footer', $button->export())->setHasFooter();
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    private function setHasHeader(bool $value = true): static
    {
        return $this->setData('hasHeader', $value);
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    private function setHasSubBody(bool $value = true): static
    {
        return $this->setData('hasSubBody', $value);
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    private function setHasBody(bool $value = true): static
    {
        return $this->setData('hasBody', $value);
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    private function setHasFooter(bool $value = true): static
    {
        return $this->setData('hasFooter', $value);
    }

    /**
     * @param array $classes
     *
     * @return $this
     */
    public function setAdditionalBodyClasses(array $classes): static
    {
        foreach ($classes as $class) {
            $this->addAdditionalBodyClass($class);
        }

        return $this;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function addAdditionalBodyClass(string $class): static
    {
        return $this->setData('additionalBodyClasses', $class, true);
    }
}
