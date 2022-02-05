<?php

    namespace Support\Abstracts;

    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldBeUnique;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Collection;

    abstract class AbstractVestaSync implements ShouldQueue, ShouldBeUnique
    {
        use Dispatchable;
        use InteractsWithQueue;
        use Queueable;
        use SerializesModels;

        /**
         * @var Collection
         */
        protected Collection $database;

        /**
         * @var Collection
         */
        protected Collection $vesta;

        /**
         * AbstractVestaSync constructor.
         *
         * @param ...$arguments
         */
        public function __construct(...$arguments)
        {
            $this->onQueue('system');

            if (method_exists(static::class, 'setup')) {
                $this->setup(...$arguments);
            }
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        final public function handle(): void
        {
            $this->sync();
        }

        private function sync()
        {
            $this->database->each(function (Model $model) {
                $this->contains($this->vesta, $model)
                    ? $this->vesta = $this->reject($this->vesta, $model)
                    : $model->delete();
            });

            $this->save($this->vesta);
        }

        abstract public function uniqueId(): string;

        /**
         * @param Collection $vesta
         * @param Model      $model
         *
         * @return bool
         */
        abstract protected function contains(Collection $vesta, Model $model): bool;

        /**
         * @param Collection $vesta
         * @param Model      $model
         *
         * @return Collection
         */
        abstract protected function reject(Collection $vesta, Model $model): Collection;

        /**
         * @param Collection $vesta
         *
         * @return void
         */
        abstract protected function save(Collection $vesta): void;
    }
