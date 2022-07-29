<?php

    namespace Domain\Job\Collections;

    use Domain\Job\Enums\JobOperationStatusTypes;
    use Domain\Job\Mappings\JobOperationTableMap;
    use Domain\Job\Models\JobOperation;
    use Illuminate\Database\Eloquent\Collection;

    class JobOperationCollections extends Collection
    {
        /**
         * @return bool
         */
        public function isProcessed(): bool
        {
            return $this->every(function (JobOperation $processedJob) {
                return $processedJob->status->isProcessed();
            });
        }

        /**
         * @return bool
         */
        public function hasFailed(): bool
        {
            return $this->contains(
                JobOperationTableMap::STATUS,
                JobOperationStatusTypes::FAILED
            );
        }

        /**
         * @return int|null
         */
        public function firstStarted(): ?int
        {
            return $this->min(JobOperationTableMap::START_TIME);
        }

        /**
         * @return int|null
         */
        public function lastEnded(): ?int
        {
            return $this->max(JobOperationTableMap::END_TIME);
        }
    }
