<?php

namespace Domain\Monitor\Enums;

use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Traits\DatabaseEnumSearch;

enum MonitorStatusType: int
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
     * @param MonitorStatusType $statusTypes
     *
     * @return bool
     */
    private function isStatus(MonitorStatusType $statusTypes): bool
    {
        return $this === $statusTypes;
    }

    /**
     * @return bool
     */
    public function isWaiting(): bool
    {
        return $this->isStatus(self::WAITING);
    }

    /**
     * @return bool
     */
    public function isProgressing(): bool
    {
        return $this->isStatus(self::PROCESSING);
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->isStatus(self::SUCCESS);
    }

    /**
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->isStatus(self::FAILED);
    }

    /**
     * @return bool
     */
    public function isRetry(): bool
    {
        return $this->isStatus(self::RETRY);
    }

    /**
     * @return bool
     */
    public function isProcessed(): bool
    {
        return $this->isSuccess() || $this->isFailed();
    }
}
