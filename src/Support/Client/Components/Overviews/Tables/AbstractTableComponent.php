<?php

namespace Support\Client\Components\Overviews\Tables;

use Illuminate\Support\Arr;
use Support\Client\Components\Component;
use Support\Helpers\VuexNamespaceHelper;

abstract class AbstractTableComponent extends Component
{
    /**
     * @var array|int[]
     */
    private array $totalPerPageOptions = [10, 25, 50];

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
     * @return $this
     */
    public function setSearchable(): static
    {
        return $this->setData('searchable', true);
    }

    /**
     * @param string|VuexNamespaceHelper $vuexNamespace
     *
     * @return $this
     */
    public function setVuexNamespace(string|VuexNamespaceHelper $vuexNamespace): static
    {
        $value = optional($vuexNamespace)->export() ?: $vuexNamespace;

        return $this->setData('vuexNamespace', $value);
    }

    /**
     * @return $this
     */
    public function setRefreshButton(): static
    {
        return $this->setData('refreshButton', true);
    }

    /**
     * @param array    $options
     * @param int|null $default
     *
     * @return $this
     */
    public function setTotalPerPageOpOptions(array $options, ?int $default = null): static
    {
        $this->totalPerPageOptions = Arr::map($options, 'abs');

        return $this->setTotalPerPage($default ?: $this->totalPerPageOptions[0]);
    }

    /**
     * @param int $total
     *
     * @return $this
     */
    public function setTotalPerPage(int $total): static
    {
        if (\in_array($total, $this->totalPerPageOptions)) {
            $this->setData('totalPerPage', $total);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param array  $attributes
     *
     * @return $this
     */
    public function setRoutes(string $name, array $attributes = []): static
    {
        $name = "{$name}.table";

        return $this->setHeaderRoute(route("{$name}.headers", $attributes))
            ->setItemsRoute(route("{$name}.items", $attributes))
            ->setChannelRoute("{$name}.channel");
    }

    /**
     * @param string $route
     *
     * @return $this
     */
    public function setHeaderRoute(string $route): static
    {
        return $this->setData('headerRoute', $route);
    }

    /**
     * @param string $route
     *
     * @return $this
     */
    public function setItemsRoute(string $route): static
    {
        return $this->setData('itemsRoute', $route);
    }

    /**
     * @param string $route
     *
     * @return $this
     */
    public function setChannelRoute(string $route): static
    {
        return $this->setData('channelRoute', $route);
    }

    /**
     * @param Component $component
     *
     * @return $this
     */
    public function setPrependComponent(Component $component): static
    {
        return $this->setData('prepend', $component->export());
    }

    /**
     * @param Component $component
     *
     * @return $this
     */
    public function setAppendComponent(Component $component): static
    {
        return $this->setData('append', $component->export());
    }

    /**
     * @return $this
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
        $this->setData('totalPerPageOptions', $this->totalPerPageOptions);

        return parent::export();
    }
}
