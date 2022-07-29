<?php

namespace Domain\Job\Enums;

use Support\Enums\Component\Vuetify\VuetifyColors;
use Support\Traits\DatabaseEnumSearch;

enum JobOperationStatusTypes: int
{
    use DatabaseEnumSearch;

    case WAITING = 0;
    case PROCESSING = 1;
    case SUCCESS = 2;
    case FAILED = 3;
    case RETRY = 4;

    /**
     * @return array
     */
    public static function getTranslations(): array
    {
        return [
            self::WAITING->value => trans('word.waiting'),
            self::PROCESSING->value => trans('word.processing'),
            self::SUCCESS->value => trans('word.success'),
            self::FAILED->value => trans('word.failed'),
            self::RETRY->value => trans('word.retry'),
        ];
    }

    /**
     * @return VuetifyColors
     */
    public function getColor(): VuetifyColors
    {
        return match ($this) {
            self::WAITING => VuetifyColors::LIGHT_GRAY,
            self::PROCESSING, self::RETRY => VuetifyColors::WARNING,
            self::SUCCESS => VuetifyColors::SUCCESS,
            self::FAILED => VuetifyColors::ERROR
        };
    }

    /**
     * @param JobOperationStatusTypes $statusTypes
     *
     * @return bool
     */
    private function isStatus(JobOperationStatusTypes $statusTypes): bool
    {
        return $this === $statusTypes;
    }

    /**
     * @return bool
     */
    public function isStatusWaiting(): bool
    {
        return $this->isStatus(self::WAITING);
    }

    /**
     * @return bool
     */
    public function isStatusProgressing(): bool
    {
        return $this->isStatus(self::PROCESSING);
    }

    /**
     * @return bool
     */
    public function isStatusSuccess(): bool
    {
        return $this->isStatus(self::SUCCESS);
    }

    /**
     * @return bool
     */
    public function isStatusFailed(): bool
    {
        return $this->isStatus(self::FAILED);
    }

    /**
     * @return bool
     */
    public function isStatusRetry(): bool
    {
        return $this->isStatus(self::RETRY);
    }

    /**
     * @return bool
     */
    public function isProcessed(): bool
    {
        return $this->isStatusSuccess() || $this->isStatusFailed();
    }
}
