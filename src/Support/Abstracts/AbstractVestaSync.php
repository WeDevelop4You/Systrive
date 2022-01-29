<?php

    namespace Support\Abstracts;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Collection;

    abstract class AbstractVestaSync
    {
        /**
         * @var Collection
         */
        protected Collection $database;

        /**
         * @var Collection
         */
        protected Collection $vesta;

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle(): void
        {
            $this->sync();
        }

        protected function sync()
        {
            $this->database->each(function (Model $model) {
                $this->contains($this->vesta, $model)
                    ? $this->vesta = $this->reject($this->vesta, $model)
                    : $model->delete();
            });

            $this->save($this->vesta);
        }

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
