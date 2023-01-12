<?php

namespace Domain\Cms\Enums;

use Domain\Cms\Columns\Types\AbstractColumnType;
use Domain\Cms\Columns\Types\BooleanColumnType;
use Domain\Cms\Columns\Types\DateColumnType;
use Domain\Cms\Columns\Types\DatetimeColumnType;
use Domain\Cms\Columns\Types\DecimalColumnType;
use Domain\Cms\Columns\Types\FileColumnType;
use Domain\Cms\Columns\Types\IdColumnType;
use Domain\Cms\Columns\Types\IntegerColumnType;
use Domain\Cms\Columns\Types\RichTextColumnType;
use Domain\Cms\Columns\Types\StringColumnType;
use Domain\Cms\Columns\Types\TextColumnType;
use Domain\Cms\Columns\Types\TimeColumnType;
use Domain\Cms\Models\CmsColumn;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

enum CmsColumnType: int
{
    case ID = 0;
    case TEXT = 1;
    case JSON = 2;
    case TIME = 3;
    case DATE = 4;
    case FILE = 5;
    case IMAGE = 6;
    case STRING = 9;
    case BOOLEAN = 10;
    case INTEGER = 11;
    case DECIMAL = 12;
    case DATETIME = 13;
    case RELATION = 14;
    case RICH_TEXT = 15;

    private const HIDDEN_CASES = [
        // TODO implement later
        self::JSON,
        self::IMAGE,
        self::RELATION,
    ];

    /**
     * @return string
     */
    public function trans(): string
    {
        return match ($this) {
            self::ID => trans('word.id'),
            self::TEXT => trans('word.text'),
            self::JSON => trans('word.json'),
            self::TIME => trans('word.time'),
            self::DATE => trans('word.date'),
            self::FILE => trans('word.file'),
            self::IMAGE => trans('word.image'),
            self::STRING => trans('word.string'),
            self::BOOLEAN => trans('word.boolean'),
            self::INTEGER => trans('word.integer'),
            self::DECIMAL => trans('word.decimal'),
            self::DATETIME => trans('word.datetime'),
            self::RELATION => trans('word.relation'),
            self::RICH_TEXT => trans('word.rich_text'),
        };
    }

    /**
     * @throws Exception
     *
     * @return string
     */
    private function getClassname(): string
    {
        return match ($this) {
            self::ID => IdColumnType::class,
            self::TEXT => TextColumnType::class,
            self::JSON => throw new Exception('To be implemented'),
            self::TIME => TimeColumnType::class,
            self::DATE => DateColumnType::class,
            self::FILE => FileColumnType::class,
            self::IMAGE => throw new Exception('To be implemented'),
            self::STRING => StringColumnType::class,
            self::BOOLEAN => BooleanColumnType::class,
            self::INTEGER => IntegerColumnType::class,
            self::DECIMAL => DecimalColumnType::class,
            self::DATETIME => DatetimeColumnType::class,
            self::RELATION => throw new Exception('To be implemented'),
            self::RICH_TEXT => RichTextColumnType::class,
        };
    }

    /**
     * @param CmsColumn $column
     *
     * @return AbstractColumnType
     */
    public function create(CmsColumn $column): AbstractColumnType
    {
        return App::call([$this->getClassname(), 'create'], ['column' => $column]);
    }

    /**
     * @return Collection
     */
    public function getOptions(): Collection
    {
        return App::call([$this->getClassname(), 'getOptions']);
    }

    public static function getVisibleValues(): array
    {
        $types = [];

        foreach (self::cases() as $case) {
            if (!\in_array($case, self::HIDDEN_CASES)) {
                $types[] = $case;
            }
        }

        return $types;
    }
}
