<?php

    namespace Support\Abstracts;

    use Carbon\CarbonPeriod;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Collection;

    abstract class AbstractChart
    {
        /**
         * @var int
         */
        protected int $period = 2;

        /**
         * @var Carbon
         */
        protected readonly Carbon $startDate;

        /**
         * @var Carbon
         */
        protected readonly Carbon $endDate;

        /**
         * @var Collection
         */
        protected readonly Collection $periodRange;

        /**
         * @var array
         */
        private array $labels = [];

        /**
         * @var array
         */
        private array $data = [];

        /**
         * @param mixed ...$attribute
         *
         * @return array
         */
        public static function create(...$attribute): array
        {
            $instance = new static(...$attribute);

            $addDay = (int) Carbon::now()->lt(Carbon::today()->addHours(4));

            $instance->endDate = Carbon::now()->subDays($addDay);
            $instance->startDate = Carbon::now()->subWeeks(2)->subDays($addDay);
            $instance->periodRange = Collection::make(
                CarbonPeriod::create($instance->startDate, $instance->endDate)
            )->map(function (Carbon $date) {
                return $date->toDateString();
            });

            $instance->setLabels($instance->periodRange->toArray());

            $instance->handle();

            return $instance->export();
        }

        /**
         * @param array $labels
         */
        protected function setLabels(array $labels): void
        {
            $this->labels = $labels;
        }

        /**
         * @param array $data
         *
         * @return void
         */
        protected function setData(array $data): void
        {
            $this->data = $data;
        }

        /**
         * @param string $key
         * @param array  $data
         */
        protected function addData(string $key, array $data): void
        {
            $this->data[$key] = $data;
        }

        /**
         * @return array
         */
        private function export(): array
        {
            return [
                'labels' => $this->labels,
                'data' => $this->data,
            ];
        }

        abstract protected function handle(): void;
    }
