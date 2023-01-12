<?php

namespace Support\Client\DataTable\Build;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Support\Client\Components\Component;

class Rows
{
    /**
     * @var int
     */
    private int $index;

    /**
     * Rows constructor.
     *
     * @param Collection $items
     * @param Collection $columns
     * @param Request    $request
     */
    private function __construct(
        private readonly Collection $items,
        private readonly Collection $columns,
        private readonly Request $request
    ) {
        $page = $this->request->query('page', 1);
        $perPage = $this->request->query('itemsPerPage', 10);

        $this->index = ($page - 1) * $perPage;
    }

    /**
     * @param Collection $items
     * @param Collection $columns
     * @param Request    $request
     *
     * @return array
     */
    public static function create(Collection $items, Collection $columns, Request $request): array
    {
        $instance = new static($items, $columns, $request);

        return $instance->items->map(function (mixed $data) use ($instance) {
            $instance->index++;

            return $instance->fillColumnsWithData($data);
        })->values()->toArray();
    }

    /**
     * @param mixed $data
     *
     * @return array
     */
    private function fillColumnsWithData(mixed $data): array
    {
        return $this->columns->mapWithKeys(function (Column $column) use ($data) {
            $value = match (true) {
                $column->hasFormat => $this->getDataFromFormat($column, $data),
                $data instanceof Model => $this->getDataFromModel($column, $data),
                default => $this->getDataFromArray($column, $data)
            };

            return [$column->identifier => \is_null($value) ? '' : $value];
        })->toArray();
    }

    /**
     * @param Column $column
     * @param mixed  $data
     *
     * @return array|mixed
     */
    private function getDataFromFormat(Column $column, mixed $data): mixed
    {
        $format = App::call($column->getFormatCallback(), [
            'key' => $column->getKey(),
            'data' => $data,
            'index' => $this->index,
        ]);

        if ($format instanceof Component) {
            return $format->export();
        }

        return $format;
    }

    /**
     * @param Column $column
     * @param Model  $data
     *
     * @return mixed
     */
    private function getDataFromModel(Column $column, Model $data): mixed
    {
        foreach (explode('.', $column->getKey()) as $key) {
            $data = $data?->getAttribute($key);
        }

        return $data;
    }

    /**
     * @param Column $column
     * @param        $data
     *
     * @return mixed
     */
    private function getDataFromArray(Column $column, $data): mixed
    {
        return Arr::get($data, $column->getKey());
    }
}
