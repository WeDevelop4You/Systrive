<?php

namespace Domain\Job\Enums;

use Support\Enums\Component\Vuetify\VuetifyColor;
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
     * @return VuetifyColor
     */
    public function getColor(): VuetifyColor
    {
        return match ($this) {
            self::WAITING => VuetifyColor::LIGHT_GRAY,
            self::PROCESSING, self::RETRY => VuetifyColor::WARNING,
            self::SUCCESS => VuetifyColor::SUCCESS,
            self::FAILED => VuetifyColor::ERROR
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
