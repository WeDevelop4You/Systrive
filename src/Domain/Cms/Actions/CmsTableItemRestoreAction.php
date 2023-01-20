<?php

namespace Domain\Cms\Actions;

use Domain\Cms\Exceptions\CmsTableItemException;
use Domain\Cms\Models\CmsModel;
use Exception;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class CmsTableItemRestoreAction
{
    /**
     * @param CmsModel $model
     *
     * @throws CmsTableItemException
     * @throws Throwable
     * @return void
     */
    public function __invoke(CmsModel $model): void
    {
        $db = DB::connection('cms');

        try {
            $db->beginTransaction();

            $active = CmsModel::latest()->first();
            $active->files->each->delete();

            $model->load([
                'files' => fn (MorphMany $query) => $query->withTrashed()
            ]);

            $model->created_at = Carbon::now();
            $model->files->each->restore();
            $model->save();

            $db->commit();
        } catch (Exception$e) {
            $db->rollBack();

            throw new CmsTableItemException('Something went wrong while restoring a item', previous: $e);
        } finally {
            $db->rollBack();
        }
    }
}
