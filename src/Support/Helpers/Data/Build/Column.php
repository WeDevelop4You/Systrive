<?php

    namespace Support\Helpers\Data\Build;

    use Support\Enums\Vuetify\VuetifyTableAlignmentTypes;
    use Support\Traits\DatabaseEnumSearch;

    /**
     * @property-read bool                       $hasDivider
     * @property-read bool                       $isSortable
     * @property-read bool                       $isSearchable
     * @property-read bool                       $isEnumSearch
     * @property-read VuetifyTableAlignmentTypes $alignment
     */
    class Column
    {
        private $sortCallback = null;
        private $searchCallback = null;

        /**
         * @param string $identifier
         * @param string $text
         */
        private function __construct(
            public readonly string $identifier,
            public readonly string $text
        ) {
            $this->hasDivider = false;
            $this->isSortable = false;
            $this->isSearchable = false;
            $this->isEnumSearch = false;

            $this->alignment = VuetifyTableAlignmentTypes::START;
        }

        /**
         * @param string $identifier
         * @param string $text
         *
         * @return Column
         */
        public static function create(string $identifier, string $text): Column
        {
            return new static($identifier, $text);
        }

        /**
         * @return Column
         */
        public static function index(): Column
        {
            return new static('index', '#');
        }

        /**
         *
         * @return Column
         */
        public static function id(): Column
        {
            $instance = new static('id', 'ID');
            $instance->sortable()->sortable();

            return $instance;
        }

        /**
         * @return Column
         */
        public static function actions(): Column
        {
            $instance = new static('actions', trans('word.actions.actions'));
            $instance->setAlignment(VuetifyTableAlignmentTypes::END);

            return $instance;
        }

        public function setDivider(bool $value = true): Column
        {
            $this->hasDivider = $value;

            return $this;
        }

        /**
         * @param null $callback
         *
         * @return Column
         */
        public function sortable($callback = null): Column
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
            return !is_null($this->sortCallback);
        }

        public function getSortCallback()
        {
            return $this->sortCallback;
        }

        /**
         * @param $callback
         *
         * @return Column
         */
        public function searchable($callback = null): Column
        {
            $this->isSearchable = true;
            $this->searchCallback = $callback;

            if (!is_null($callback) && !is_callable($callback) && is_string($callback)) {
                $this->isEnumSearch = (
                    enum_exists($callback) && in_array(
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
            return !is_null($this->searchCallback);
        }

        public function getSearchCallback()
        {
            return $this->searchCallback;
        }

        public function setAlignment(VuetifyTableAlignmentTypes $value): Column
        {
            $this->alignment = $value;

            return $this;
        }

        public function __get(string $name)
        {
            return $this->$name;
        }
    }
