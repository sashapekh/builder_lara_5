<?php

namespace Vis\Builder;

use Illuminate\Routing\Controller;

class ChangeRangeController extends Controller
{
    public function doChangeValue()
    {
        $model = request('model');

        $modelCard = new $model();

        return $modelCard->calculate();
    }

    public function doChangeTrend()
    {
        $model = request('model');

        $modelCard = new $model();

        return $modelCard->calculate();
    }
}
