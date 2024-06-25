<?php

namespace Vis\Builder\Services\Tree;

use Illuminate\Database\Eloquent\Model;
use Vis\Builder\TreeController;

final class CustomTreeService
{
    /** @var Model|null $node */
    private $node;
    private $definitionConfig;

    private $modelClass;

    private $segmentsUri;
    private $uri;
    private $fullUrl;

    private $controllerClass;
    private $controllerMethod;

    /**
     * @throws \Exception
     */
    public function handle(array $definitionConfig)
    {
        $this->definitionConfig = $definitionConfig;
        $this->prepare();

        /** @var TreeController $controller */
        $controller = app()->make($this->controllerClass);
        return $controller->init($this->node, $this->controllerMethod);
    }


    public function getNode(): ?Model
    {
        return $this->node;
    }

    private function findNode(): ?Model
    {
        $segments = $this->segmentsUri;

        while ($segment = array_pop($segments)) {
            if ($node = $this->modelClass::where('slug', $segment)
                ->where('is_active', 1)
                ->first()) {
                return $node;
            }
        }
        return null;
    }


    private function prepareUrl()
    {
        $excludeSegments = $this->definitionConfig['settings']['exclude_search_segments'] ?? null;
        $this->uri = request()->getRequestUri();
        $this->segmentsUri = request()->segments();
        $this->fullUrl = request()->fullUrl();

        $this->segmentsUri = array_values(
            array_filter($this->segmentsUri, function ($segment) use ($excludeSegments) {
                return !in_array($segment, $excludeSegments);
            })
        );
    }

    /**
     * @throws \Exception
     */
    private function prepare()
    {
        $this->modelClass = $this->definitionConfig['model'];
        if (!$this->modelClass) {
            throw new \Exception('Model not found in definition config');
        }
        $this->prepareUrl();
        $this->node = $this->findNode();
        $this->prepareControllerData();
    }

    private function prepareControllerData()
    {
        $template = $this->definitionConfig['templates'][$this->node->template];
        $action = $template['action'];
        if (is_array($action)) {
            $actionArr = $action;
            $this->controllerClass = $actionArr[0];
        } else {
            $actionArr = explode('@', $action);
            $this->controllerClass = "App\Http\Controllers\\".ucfirst($actionArr[0]);
        }

        $this->controllerMethod = $actionArr[1];
    }
}