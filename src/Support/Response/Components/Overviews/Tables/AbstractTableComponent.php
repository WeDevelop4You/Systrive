<?php

namespace Support\Response\Components\Overviews\Tables;

use Support\Response\Components\AbstractComponent;

abstract class AbstractTableComponent extends AbstractComponent
{
    protected function __construct()
    {
        parent::__construct();

        $this->setData('type', $this->getType());
    }

    /**
     * @return string
     */
    abstract protected function getType(): string;

    /**
     * @return string
     */
    protected function getComponentName(): string
    {
        return 'Table';
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
     * @return static
     */
    public function setSearchable(): static
    {
        return $this->setAttribute('searchable', true);
    }

    /**
     * @param string $vuexNamespace
     *
     * @return static
     */
    public function setVuexNamespace(string $vuexNamespace): static
    {
        return $this->setAttribute('vuexNamespace', $vuexNamespace);
    }

    /**
     * @return static
     */
    public function setRefreshButton(): static
    {
        return $this->setAttribute('refreshButton', true);
    }

    /**
     * @param array $itemsPerPage
     *
     * @return static
     */
    public function setItemsPerPage(array $itemsPerPage): static
    {
        return $this->setAttribute('itemsPerPageOptions', $itemsPerPage);
    }

    /**
     * @param string $url
     *
     * @return static
     */
    public function setHeaderUrl(string $url): static
    {
        return $this->setData('headerUrl', $url);
    }

    /**
     * @param string $url
     *
     * @return static
     */
    public function setItemsUrl(string $url): static
    {
        return $this->setData('itemsUrl', $url);
    }

    /**
     * @param AbstractComponent $component
     *
     * @return static
     */
    public function setPrependComponent(AbstractComponent $component): static
    {
        return $this->setData('prepend', $component->export());
    }

    /**
     * @param AbstractComponent $component
     *
     * @return static
     */
    public function setAppendComponent(AbstractComponent $component): static
    {
        return $this->setData('append', $component->export());
    }
}
