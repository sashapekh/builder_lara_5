<?php

namespace Vis\Builder;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;

/**
 * Class TreeController.
 */
class TreeController extends Controller
{
    protected $node;

    /**
     * @param $node
     * @param $method
     *
     * @return mixed
     */
    public function init($node, $method)
    {
        if (! $node->active(App::getLocale()) && ! Input::has('show')) {
            App::abort(404);
        }
        $this->node = $node;

        return $this->$method();
    }
}
