<?php

namespace Vis\Builder;

use Illuminate\Routing\Controller;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPage()
    {
        $dashboardConfig = config('builder.dashboard');

        $columns = $dashboardConfig['columns'];
        $countColoums = count($columns);
        $nameClassGrid = 12 / $countColoums;

        return view(
            'admin::dashboard.index',
            compact('columns', 'nameClassGrid')
        );
    }
}
