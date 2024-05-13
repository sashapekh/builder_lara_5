<?php

namespace Vis\Builder\Helpers\Traits;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\View;

trait QuickEditTrait
{
    public function editor($field)
    {
        $user = Sentinel::getUser();

        if (Sentinel::check() && $user->hasAccess(['admin.access'])) {
            $pageEditor = $this;
            $fieldEdit = 'editor_init_'.get_class($pageEditor).'_'.$field.'_'.$pageEditor->id;

            return view('admin::partials.editor_init', compact('pageEditor', 'field', 'fieldEdit'));
        } else {
            return $this->$field;
        }
    }
}
