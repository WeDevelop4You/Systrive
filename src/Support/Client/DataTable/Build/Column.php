<?php

namespace Support\Client\DataTable\Build;

use Support\Enums\Component\Vuetify\VuetifyTableAlignmentType;
use Support\Traits\DatabaseEnumSearch;

/**
 * @property-read bool                      $hasDivider
 * @property-read bool                      $isSortable
 * @property-read bool                      $isSearchable
 * @property-read bool                      $isEnumSearch
 * @property-read bool                      $hasFormat
 * @property-read VuetifyTableAlignmentType $alignment
 */
class Column
{
    private $sortCallback = null;
    private $searchCallback = null;
    private $formatCallback = null;

    /**
     * Column constructor.
     *
     * @param string      $label
     * @param string      $identifier
     * @param string|null $key
     */
    private function __construct(
        public readonly string $label,
        public readonly string $identifier,
        public readonly ?string $key = null
    ) {
        $this->hasDivider = false;
        $this->isSortable = false;
        $this->isSearchable = false;
        $this->isEnumSearch = false;
        $this->hasFormat = false;

        $this->alignment = VuetifyTableAlignmentType::START;
    }

    /**
     * @param string      $label
     * @param string      $identifier
     * @param string|null $key
     *
     * @return Column
     */
    public static function create(string $label, string $identifier, ?string $key = null): Column
    {
        return new static($label, $identifier, $key);
    }

    /**
     * @param string|null $key
     *
     * @return Column
     */
    public static function index(?string $key = null): Column
    {
        return static::create('#', 'index', $key)
            ->setFormat(fn ($index) => $index);
    }

    /**
     * @param string|null $key
     *
     * @return Column
     */
    public static function id(?string $key = null): Column
    {
        return static::create('ID', 'id', $key)
            ->setSortable()
            ->setSearchable();
    }

    /**
     * @param string|null $key
     *
     * @return Column
     */
    public static function actions(?string $key = null): Column
    {
        return static::create(trans('word.actions.actions'), 'actions', $key)
            ->setAlignment(VuetifyTableAlignmentType::END);
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setDivider(bool $value = true): Column
    {
        $this->hasDivider = $value;

        return $this;
    }

    /**
     * @param callable|null $callback
     *
     * @return Column
     */
    public function setSortable(?callable $callback = null): Column
    {
        $this->isSortable = true;
        $this->sortCallback = $callback;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasSortCallback(): bool
    {
        return !\is_null($this->sortCallback);
    }

    /**
     * @return callable|null
     */
    public function getSortCallback(): ?callable
    {
        return $this->sortCallback;
    }

    /**
     * @param $callback
     *
     * @return Column
     */
    public function setSearchable($callback = null): Column
    {
        $this->isSearchable = true;
        $this->searchCallback = $callback;

        if (!\is_null($callback) && !\is_callable($callback) && \is_string($callback)) {
            $this->isEnumSearch = (
                enum_exists($callback) && \in_array(
                    DatabaseEnumSearch::class,
                    class_uses_recursive($callback)
                )
            );
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function hasSearchCallback(): bool
    {
        return !\is_null($this->searchCallback);
    }

    /**
     * @return callable|string|null
     */
    public function getSearchCallback(): callable|string|null
    {
        return $this->searchCallback;
    }

    /**
     * @param VuetifyTableAlignmentType $value
     *
     * @return $this
     */
    public function setAlignment(VuetifyTableAlignmentType $value): Column
    {
        $this->alignment = $value;

        return $this;
    }

    /**
     * @param callable $callback
     *
     * @return $this
     */
    public function setFormat(callable $callback): Column
    {
        $this->hasFormat = true;
        $this->formatCallback = $callback;

        return $this;
    }

    public function getFormatCallback(): callable
    {
        return $this->formatCallback;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key ?: $this->identifier;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->$name;
    }

    /**
     * @return array
     */
    public function export(): array
    {
        return [
            'text' => $this->label,
            'value' => $this->identifier,
            'divider' => $this->hasDivider,
            'sortable' => $this->isSortable,
            'align' => $this->alignment->value,
            'filterable' => $this->isSearchable,
        ];
    }
}
