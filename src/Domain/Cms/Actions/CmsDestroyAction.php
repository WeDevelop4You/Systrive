<?php

namespace Domain\Cms\Actions;

use Domain\Cms\Models\Cms;

class CmsDestroyAction
{
    /**
     * @param Cms $cms
     *
     * @return bool
     */
    public function __invoke(Cms $cms): bool
    {
        return $cms->delete();
    }
}
