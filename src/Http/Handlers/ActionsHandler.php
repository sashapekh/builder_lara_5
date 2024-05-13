<?php

namespace Vis\Builder\Handlers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

/**
 * Class ActionsHandler.
 */
class ActionsHandler
{
    /**
     * @var array
     */
    protected $def;
    /**
     * @var
     */
    protected $controller;

    /**
     * ActionsHandler constructor.
     *
     * @param array $actionsDefinition
     * @param $controller
     */
    public function __construct(array $actionsDefinition, &$controller)
    {
        $this->def = $actionsDefinition;
        $this->controller = $controller;
    }

    /**
     * @param $type
     * @param array $row
     * @param array $buttonDefinition
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function fetch($type, $row = [], $buttonDefinition = [])
    {
        switch ($type) {
            case 'insert':
                return $this->onInsertButton();

            case 'update':
                return $this->onUpdateButton($row);

            case 'clone':
                return $this->onСloneButton($row);

            case 'revisions':
                return $this->onRevisionsButton($row);

            case 'preview':
                return $this->onPreviewButton($row);

            case 'delete':
                return $this->onDeleteButton($row);

            case 'views_statistic':
                return $this->onViewStatisticButton($row);

            case 'constructor':
                return $this->onConstructorButton($row, $buttonDefinition);

            case 'custom':
                return $this->onCustomButton($row, $buttonDefinition);

            default:
                return;
        }
    }

    /**
     * @param $row
     * @param $button
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function onCustomButton($row, $button)
    {
        $action = view('admin::tb.action_custom');
        $action->row = $row;
        $action->def = $button;
        $action->definition = $this->controller->getDefinition();

        return $action;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function onInsertButton()
    {
        if ($this->controller->hasCustomHandlerMethod('onInsertButtonFetch')) {
            $res = $this->controller->getCustomHandler()->onInsertButtonFetch($this->def['insert']);
            if ($res) {
                return $res;
            }
        }

        $action = view('admin::tb.action_insert');
        $action->def = $this->def['insert'];
        $action->definition = $this->controller->getDefinition();

        return $action;
    }

    /**
     * @param $row
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function onUpdateButton($row)
    {
        if ($this->controller->hasCustomHandlerMethod('onUpdateButtonFetch')) {
            $res = $this->controller->getCustomHandler()->onUpdateButtonFetch($this->def['update']);
            if ($res) {
                return $res;
            }
        }

        $action = view('admin::tb.action_update');
        $action->row = $row;
        $action->def = $this->def['update'];
        $action->definition = $this->controller->getDefinition();

        return $action;
    }

    /**
     * @param $row
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function onRevisionsButton($row)
    {
        $action = view('admin::tb.action_revisions');
        $action->row = $row;
        $action->def = $this->def['revisions'];
        $action->definition = $this->controller->getDefinition();

        return $action;
    }

    /**
     * @param $row
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function onСloneButton($row)
    {
        if ($this->controller->hasCustomHandlerMethod('onCloneButtonFetch')) {
            $res = $this->controller->getCustomHandler()->onUpdateButtonFetch($this->def['clone']);
            if ($res) {
                return $res;
            }
        }

        $action = view('admin::tb.action_clone');
        $action->row = $row;
        $action->def = $this->def['clone'];
        $action->definition = $this->controller->getDefinition();

        return $action;
    }

    /**
     * @param $row
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function onViewStatisticButton($row)
    {
        $action = view('admin::tb.action_views_statistic');
        $action->row = $row;
        $action->def = $this->def['views_statistic'];
        $action->definition = $this->controller->getDefinition();

        return $action;
    }

    /**
     * @param $row
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function onPreviewButton($row)
    {
        $action = view('admin::tb.action_preview');
        $action->row = $row;
        $action->def = $this->def['preview'];
        $action->definition = $this->controller->getDefinition();
        $model = $action->definition['options']['model'];
        $action->model = $model;
        $action->url = $this->getUrl($action, $model, $row['id']);

        $params['show'] = 1;

        $action->url .= '?'.http_build_query($params);

        return $action;
    }

    /**
     * @param $row
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function onConstructorButton($row)
    {
        $action = view('admin::tb.action_constructor');
        $action->row = $row;
        $action->def = $this->def['constructor'];
        $action->definition = $this->controller->getDefinition();
        $model = $action->definition['options']['model'];
        $action->model = $model;
        $action->url = $this->getUrl($action, $model, $row['id']).'?mode=construct';

        return $action;
    }

    /**
     * @param $action
     * @param $model
     * @param $id
     *
     * @return mixed
     */
    private function getUrl($action, $model, $id)
    {
        if (isset($action->definition['cache']['tags'])) {
            return Cache::tags($action->definition['cache']['tags'])
                ->rememberForever('url'.$model.$id, function () use ($model, $id) {
                    return $model::find($id)->getUrl();
                });
        }

        return $model::find($id)->getUrl();
    }

    /**
     * @param $row
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function onDeleteButton($row)
    {
        if ($this->controller->hasCustomHandlerMethod('onDeleteButtonFetch')) {
            $res = $this->controller->getCustomHandler()->onDeleteButtonFetch($this->def['delete']);
            if ($res) {
                return $res;
            }
        }

        $action = view('admin::tb.action_delete');
        $action->row = $row;
        $action->def = $this->def['delete'];
        $action->definition = $this->controller->getDefinition();

        return $action;
    }
}
