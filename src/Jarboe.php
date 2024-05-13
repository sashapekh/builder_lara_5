<?php

namespace Vis\Builder;

use Illuminate\Support\Facades\Config;
use Vis\Builder\Helpers\URLify;

/**
 * Class Jarboe.
 */
class Jarboe
{
    protected $controller;
    protected $default;

    /**
     * @param $options
     */
    protected function onInit($options)
    {
        $this->controller = new JarboeController($options);
    }

    protected function onFinish()
    {
        Config::set('view.pagination', $this->default['pagination']);
        Config::set('database.fetch', $this->default['fetch']);
    }

    /**
     * @param $options
     *
     * @return mixed
     */
    public function table($options)
    {
        $this->onInit($options);

        return $this->controller->handle();
    }

    /**
     * @param string $string
     *
     * @return string string
     */
    public function urlify($string)
    {
        return URLify::filter($string);
    }

    /**
     * @param string $model
     * @param array  $options
     * @param string $nameTree
     *
     * @return TreeCatalogController
     */
    public function tree(
        $model = 'Vis\Builder\Tree',
        $options = [
            'url'      => '/admin/tree',
            'def_name' => 'tree/node',
        ],
        $nameTree = 'tree'
    ) {
        return new TreeCatalogController($model, $options, $nameTree);
    }
}
