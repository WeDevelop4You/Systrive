<?php

    namespace Support\Helpers\Table;

    /**
     * Class TableColumn
     *
     * @property-read string $columnName
     * @property-read $isSortable
     * @property-read $sortCallback
     * @property-read $isSearchable
     * @property-read $searchCallback
     */
    class TableColumn
    {
        /**
         * @param string $columnName
         */
        public function __construct(string $columnName)
        {
            $this->isSortable = false;
            $this->isSearchable = false;
            $this->columnName = $columnName;
        }

        /**
         * @param string $columnName
         * @return TableColumn
         */
        public static function create(string $columnName): TableColumn
        {
            return new static($columnName);
        }

        /**
         * @param $sortCallback
         * @return TableColumn
         */
        public function sortable($sortCallback = null): TableColumn
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
         * @return TableColumn
         */
        public function searchable($searchCallback = null): TableColumn
        {
            $this->isSearchable = true;
            $this->searchCallback = $searchCallback;

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
         * @return mixed
         */
        public function __get($name)
        {
            return $this->$name;
        }
    }
