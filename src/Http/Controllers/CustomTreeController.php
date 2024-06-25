<?php

namespace Vis\Builder\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vis\Builder\Services\Tree\CustomTreeService;
use Vis\Builder\TreeController;

class CustomTreeController extends TreeController
{

    protected $customTreeService;

    public function __construct(
        CustomTreeService $customTreeService
    ) {
        $this->customTreeService = $customTreeService;
    }

    public function handle(Request $request)
    {
        $defName = null;
        $arrayOfMatches = config('builder.settings.custom_tree_handle_definitions');

        foreach ($arrayOfMatches as $matchPattern => $definitionName) {
            if ($request->is($matchPattern)) {
                $defName = $definitionName;
            }
        }

        if (!$defName) {
            throw new NotFoundHttpException();
        }
        $definition = config(sprintf('builder.%s', $defName));
        return $this->customTreeService->handle($definition);
    }
}