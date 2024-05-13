<?php

namespace Vis\Builder;

use Illuminate\Database\Eloquent\Model;

class TreeObserver
{
    public function saving(Model $model)
    {
        $model->clearCache();
    }

    public function updating(Model $model)
    {
        $model->clearCache();
    }

    public function deleting(Model $model)
    {
        $model->clearCache();
    }
}
