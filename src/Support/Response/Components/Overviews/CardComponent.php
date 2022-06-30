<?php

namespace Support\Response\Components\Overviews;

use Support\Enums\Vuetify\VuetifyColors;
use Support\Response\Components\AbstractComponent;
use Support\Response\Components\Buttons\AbstractButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;

class CardComponent extends AbstractComponent
{
    protected function __construct()
    {
        parent::__construct();

        $this->setRounded();
        $this->setOutlined();
        $this->setHasBody(false);
        $this->setHasFooter(false);
        $this->setHeaderColor(VuetifyColors::TRANSPARENT);
    }

    protected function getComponentName(): string
    {
        return 'Card';
    }

    /**
     * @param string $title
     *
     * @return static
     */
    public function setTitle(string $title): static
    {
        return $this->setContent('title', $title);
    }

    /**
     * @param bool $value
     *
     * @return static
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
     * @param VuetifyColors $colors
     *
     * @return $this
     */
    public function setColor(VuetifyColors $colors): static
    {
        return $this->setAttribute('color', $colors->value);
    }

    /**
     * @param AbstractButtonComponent|MultipleButtonComponent $button
     *
     * @return static
     */
    public function setHeaderButton(AbstractButtonComponent|MultipleButtonComponent $button): static
    {
        return $this->setData('header', $button->export());
    }

    /**
     * @param VuetifyColors $color
     *
     * @return static
     */
    public function setHeaderColor(VuetifyColors $color): static
    {
        return $this->setData('headerColor', $color->value);
    }

    /**
     * @return static
     */
    public function setLoadingBar(): static
    {
        return $this->setData('hasLoadingBar', true);
    }

    /**
     * @param array $components
     *
     * @return $this
     */
    public function setBody(array $components): static
    {
        foreach ($components as $component) {
            if ($component instanceof AbstractComponent) {
                $this->addBody($component);
            }
        }

        return $this;
    }

    /**
     * @param AbstractComponent $component
     *
     * @return static
     */
    public function addBody(AbstractComponent $component): static
    {
        return $this->setData('body', $component->export(), true)->setHasBody();
    }

    /**
     * @param bool $value
     *
     * @return static
     */
    private function setHasBody(bool $value = true): static
    {
        return $this->setData('hasBody', $value);
    }

    /**
     * @param AbstractButtonComponent|MultipleButtonComponent $button
     *
     * @return static
     */
    public function setFooterButton(AbstractButtonComponent|MultipleButtonComponent $button): static
    {
        return $this->setData('footer', $button->export())->setHasFooter();
    }

    /**
     * @param bool $value
     *
     * @return static
     */
    private function setHasFooter(bool $value = true): static
    {
        return $this->setData('hasFooter', $value);
    }

    /**
     * @param array $classes
     *
     * @return static
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
     * @return static
     */
    public function addAdditionalBodyClass(string $class): static
    {
        return $this->setData('additionalBodyClasses', $class, true);
    }
}
