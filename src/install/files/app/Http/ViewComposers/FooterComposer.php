<?php

namespace App\Http\ViewComposers;

use App\Models\Tree;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class FooterComposer
{
    public function compose(View $view)
    {
        $menu = Cache::tags(['tree'])->rememberForever('menuProduct', function () {
            $menu = Tree::isMenu()->get();

            return $menu;
        });

        $view->with(compact('menu'));
    }
}
