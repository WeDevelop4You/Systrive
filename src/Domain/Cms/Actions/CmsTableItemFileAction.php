<?php

namespace Domain\Cms\Actions;

use Domain\Cms\Exceptions\CmsTableItemException;
use Domain\Cms\Mappings\CmsFileTableMap;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsFile;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as CollectionBase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Support\Exceptions\Custom\TooManyFilesException;
use Support\Services\Cms;
use Throwable;

class CmsTableItemFileAction
{
    /**
     * @var Collection
     */
    private readonly Collection $saves;

    /**
     * @var Collection
     */
    private readonly CollectionBase $total;

    /**
     * @var Collection
     */
    private readonly Collection $delete;

    /**
     * CmsTableItemFileAction constructor
     *
     * @param Request  $request
     * @param CmsTable $table
     * @param CmsModel $model
     */
    public function __construct(
        private readonly Request $request,
        private readonly CmsTable $table,
        private readonly CmsModel $model
    ) {
        $this->saves = new Collection();

        $deleteIds = Arr::flatten($this->request->get('delete_files', []));

        [$this->delete, $exist] = $model->files->partition(
            fn (CmsFile $file) => in_array($file->id, $deleteIds)
        );

        $this->total = $exist->groupBy(CmsFileTableMap::COL_TABLE_KEY)->map->count();
    }

    /**
     * @throws TooManyFilesException
     * @throws CmsTableItemException
     * @return CmsTableItemFileAction
     */
    public function __invoke(): CmsTableItemFileAction
    {
        $this->table->fileColumns->each(function (CmsColumn $column) {
            $max = $column->property('max');
            $total = $this->getTotal($column->key);

            foreach ($this->request->get($column->key, []) as $values) {
                if ($total >= $max) {
                    throw new TooManyFilesException();
                }

                $file = Arr::has($values, 'id')
                    ? $this->getFile(Arr::get($values, 'id'))
                    : $this->createFile(Arr::get($values, 'identifier'));

                $file->table_key = $column->key;
                $file->name = Arr::get($values, 'name');

                $this->saves->add($file);

                $total++;
            }
        });

        return $this;
    }

    /**
     * @return bool
     */
    public function isDirty(): bool
    {
        return $this->delete->isNotEmpty() || $this->saves->some->isDirty();
    }

    /**
     * @param CmsModel $model
     * @param bool     $replicate
     *
     * @throws Throwable
     *
     * @return void
     */
    public function save(CmsModel $model, bool $replicate = false): void
    {
        $db = DB::connection('cms');

        $db->beginTransaction();

        if ($replicate) {
            $this->delete->each->delete();
        } else {
            $this->delete->each->forceDelete();
        }

        $this->saves->each(function (CmsFile $file) use ($model, $replicate) {
            if (!$file->exists) {
                $file->path = Storage::putFile(Cms::getCms()->storagePath(), $file->path);
            }

            if ($replicate) {
                $model->files()->save($file->replicate());

                $file->delete();

                return;
            }

            if ($file->isDirty()) {
                $model->files()->save($file);
            }
        });

        $db->commit();
    }

    /**
     * @param string $key
     *
     * @return int
     */
    private function getTotal(string $key): int
    {
        return $this->total->get($key, 0);
    }

    /**
     * @param int $id
     *
     * @throws CmsTableItemException
     * @return CmsFile
     */
    private function getFile(int $id): CmsFile
    {
        $file =  $this->model->files->firstWhere(CmsFileTableMap::COL_ID, $id);

        if ($file instanceof CmsFile) {
            return $file;
        }

        throw new CmsTableItemException();
    }

    /**
     * @param string $identifier
     *
     * @return CmsFile
     */
    private function createFile(string $identifier): CmsFile
    {
        $tmp = new File(Storage::disk('tmp')->path($identifier));

        $file = new CmsFile();
        $file->size = $tmp->getSize();
        $file->path = $tmp->getRealPath();
        $file->type = $tmp->getMimeType();

        return $file;
    }
}
