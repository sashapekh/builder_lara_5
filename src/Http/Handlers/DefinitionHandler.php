<?php

namespace Vis\Builder\Handlers;

/**
 * Class DefinitionHandler.
 */
class DefinitionHandler
{
    /**
     * @var array
     */
    private $def;
    /**
     * @var
     */
    private $controller;

    /**
     * DefinitionHandler constructor.
     *
     * @param array $definition
     * @param $controller
     */
    public function __construct(array $definition, &$controller)
    {
        $this->def = $definition;
        $this->controller = $controller;
    }

    /**
     * @return bool
     */
    public function isSortable()
    {
        return isset($this->def['options']['is_sortable']) && $this->def['options']['is_sortable'];
    }

    /**
     * @return bool
     */
    public function isMultiActions()
    {
        return isset($this->def['multi_actions']);
    }

    /**
     * @return bool
     */
    public function isShowInsert()
    {
        return isset($this->def['actions']['insert']);
    }

    /**
     * @return array
     */
    public function getFieldsList()
    {
        $result = [];

        if (! isset($this->def['fields'])) {
            return $result;
        }

        foreach ($this->def['fields'] as $name => $value) {
            if ($this->checkShowList($value)) {
                $result[] = $this->controller->getField($name);
            }
        }

        return $result;
    }

    /**
     * @param array $value
     *
     * @return bool
     */
    private function checkShowList($value)
    {
        if (in_array($value['type'], ['pattern', 'definition', 'hidden'])) {
            return false;
        }

        if (isset($value['hide_list']) && $value['hide_list']) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isFilterPresent()
    {
        $fieldsList = $this->getFieldsList();

        foreach ($fieldsList as $field) {
            if ($field->getAttribute('filter')) {
                return true;
            }
        }

        return false;
    }
}
