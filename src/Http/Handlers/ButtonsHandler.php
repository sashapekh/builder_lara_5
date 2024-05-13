<?php

namespace Vis\Builder\Handlers;

/**
 * Class ButtonsHandler.
 */
class ButtonsHandler
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
     * ButtonsHandler constructor.
     *
     * @param array $exportDefinition
     * @param $controller
     */
    public function __construct(array $exportDefinition, &$controller)
    {
        $this->def = $exportDefinition;
        $this->controller = $controller;
    }

    /**
     * @return string|void
     */
    public function fetch()
    {
        $buttons = $this->def;

        if (! count($buttons)) {
            return;
        }

        $buttonsHtml = '';

        foreach ($buttons as $button) {
            $buttonsHtml .= $this->checkShowButton($button) ? '' : view('admin::tb.button', compact('button'));
        }

        return $buttonsHtml;
    }

    /**
     * @param $button
     *
     * @return bool
     */
    private function checkShowButton($button)
    {
        return ! $button || ! $button['check']();
    }
}
