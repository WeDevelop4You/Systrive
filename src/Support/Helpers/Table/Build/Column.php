<?php

    namespace Support\Helpers\Table\Build;

    /**
     * Class TableColumn
     *
     * @property-read string $columnName
     * @property-read $isSortable
     * @property-read $sortCallback
     * @property-read $isSearchable
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
            $this->columnName = $columnName;
        }

        /**
         * @param string $columnName
         * @return Column
         */
        public static function create(string $columnName): Column
        {
            return new static($columnName);
        }

        /**
         * @param $sortCallback
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
         * @return Column
         */
        public function searchable($searchCallback = null): Column
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
