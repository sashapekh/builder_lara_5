<?php

namespace App\Http\Controllers;

use Vis\Builder\TreeController;

class HomeController extends TreeController
{
    /*
     * show index page site
     */
    public function showPage()
    {
        $page = $this->node;

        return view('home.index', compact('page'));
    }
}
