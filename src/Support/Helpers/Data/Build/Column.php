<?php

    namespace Support\Helpers\Data\Build;

    use Support\Traits\DatabaseEnumSearch;

    /**
     * Class TableColumn.
     *
     * @property-read string $columnName
     * @property-read $isSortable
     * @property-read $sortCallback
     * @property-read $isSearchable
     * @property-read $isEnumSearch
     * @property-read $searchCallback
     */
    class Column
    {
        /**
         * @param string $columnName
         */
        public function __construct(string $columnName)
        {
            $this->isSortable = false;
            $this->isSearchable = false;
            $this->isEnumSearch = false;
            $this->columnName = $columnName;
        }

        /**
         * @param string $columnName
         *
         * @return Column
         */
        public static function create(string $columnName): Column
        {
            return new static($columnName);
        }

        /**
         * @param $sortCallback
         *
         * @return Column
         */
        public function sortable($sortCallback = null): Column
        {
            $this->isSortable = true;
            $this->sortCallback = $sortCallback;

            return $this;
        }

        /**
         * @return bool
         */
        public function hasSortCallback(): bool
        {
            return !is_null($this->sortCallback);
        }

        /**
         * @param $searchCallback
         *
         * @return Column
         */
        public function searchable($searchCallback = null): Column
        {
            $this->isSearchable = true;
            $this->searchCallback = $searchCallback;

            if (!is_null($searchCallback) && !is_callable($searchCallback) && is_string($searchCallback)) {
                $this->isEnumSearch = (
                    enum_exists($searchCallback) &&
                   in_array(DatabaseEnumSearch::class, class_uses_recursive($searchCallback))
                );
            }

            return $this;
        }

        /**
         * @return bool
         */
        public function hasSearchCallback(): bool
        {
            return !is_null($this->searchCallback);
        }

        /**
         * @param $name
         *
         * @return mixed
         */
        public function __get($name): mixed
        {
            return $this->$name;
        }
    }
