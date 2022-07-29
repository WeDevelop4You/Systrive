<?php

namespace Support\Response\Components\Overviews\Tables;

use Illuminate\Support\Arr;
use Support\Response\Components\AbstractComponent;

abstract class AbstractTableComponent extends AbstractComponent
{
    /**
     * @var array|int[]
     */
    private array $totalPerPageOptions = [10, 25, 50];

    /**
     * AbstractTableComponent constructor.
     */
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
     * @param array|int[] $options
     *
     * @return static
     */
    public function setTotalPerPageOpOptions(array $options): static
    {
        $this->totalPerPageOptions = Arr::map($options, 'abs');

        return $this;
    }

    /**
     * @param int $total
     *
     * @return static
     */
    public function setTotalPerPage(int $total): static
    {
        if (\in_array($total, $this->totalPerPageOptions)) {
            $this->setAttribute('totalPerPage', $total);
        }

        return $this;
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

    /**
     * @return static
     */
    public function setFlat(): static
    {
        return $this->setData('isFlat', true);
    }

    /**
     * @return array
     */
    public function export(): array
    {
        $this->setAttribute('totalPerPageOptions', $this->totalPerPageOptions);

        return parent::export();
    }
}
