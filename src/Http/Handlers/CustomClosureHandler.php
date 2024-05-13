<?php

namespace Vis\Builder\Handlers;

use Vis\Builder\JarboeController;

/**
 * Class CustomClosureHandler.
 */
class CustomClosureHandler
{
    /**
     * @var JarboeController
     */
    public $controller;
    /**
     * @var array
     */
    private $functions = [];

    /**
     * CustomClosureHandler constructor.
     *
     * @param $functions
     * @param JarboeController $controller
     */
    public function __construct($functions, JarboeController $controller)
    {
        $this->functions = $functions;
        $this->controller = $controller;
    }

    // end __construct

    /**
     * @param string $name
     *
     * @return bool|mixed
     */
    private function getClosure($name)
    {
        return isset($this->functions[$name]) ? $this->functions[$name] : false;
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        $closure = $this->getClosure('handle');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure();
        }
    }

    /**
     * @param $formField
     * @param array $row
     * @param $postfix
     *
     * @return mixed
     */
    public function onGetValue($formField, array &$row, &$postfix)
    {
        $closure = $this->getClosure('onGetValue');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($formField, $row, $postfix);
        }
    }

    /**
     * @param $formField
     * @param $type
     * @param array $row
     * @param $postfix
     *
     * @return mixed
     */
    public function onGetExportValue($formField, $type, array &$row, &$postfix)
    {
        $closure = $this->getClosure('onGetExportValue');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($formField, $type, $row, $postfix);
        }
    }

    /**
     * @param $formField
     * @param array $row
     *
     * @return mixed
     */
    public function onGetEditInput($formField, array &$row)
    {
        $closure = $this->getClosure('onGetEditInput');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($formField, $row);
        }
    }

    /**
     * @param $formField
     * @param array $row
     *
     * @return mixed
     */
    public function onGetListValue($formField, array &$row)
    {
        $closure = $this->getClosure('onGetListValue');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($formField, $row);
        }
    }

    /**
     * @param $formField
     * @param $db
     *
     * @return mixed
     */
    public function onSelectField($formField, &$db)
    {
        $closure = $this->getClosure('onSelectField');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($formField, $db);
        }
    }

    /**
     * @param array $filters
     *
     * @return mixed
     */
    public function onPrepareSearchFilters(array &$filters)
    {
        $closure = $this->getClosure('onPrepareSearchFilters');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($filters);
        }
    }

    /**
     * @param $db
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public function onSearchFilter(&$db, $name, $value)
    {
        $closure = $this->getClosure('onSearchFilter');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($db, $name, $value);
        }
    }

    /**
     * @return mixed
     */
    public function onViewFilter()
    {
        $closure = $this->getClosure('onViewFilter');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure();
        }
    }

    /**
     * @param array $response
     *
     * @return mixed
     */
    public function onUpdateRowResponse(array &$response)
    {
        $closure = $this->getClosure('onUpdateRowResponse');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($response);
        }
    }

    /**
     * @param array $response
     *
     * @return mixed
     */
    public function onInsertRowResponse(array &$response)
    {
        $closure = $this->getClosure('onInsertRowResponse');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($response);
        }
    }

    /**
     * @param array $response
     *
     * @return mixed
     */
    public function onDeleteRowResponse(array &$response)
    {
        $closure = $this->getClosure('onDeleteRowResponse');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($response);
        }
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function handleDeleteRow($id)
    {
        $closure = $this->getClosure('handleDeleteRow');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($id);
        }
    }

    /**
     * @param $values
     *
     * @return mixed
     */
    public function handleInsertRow($values)
    {
        $closure = $this->getClosure('handleInsertRow');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($values);
        }
    }

    /**
     * @param $values
     *
     * @return mixed
     */
    public function handleUpdateRow($values)
    {
        $closure = $this->getClosure('handleUpdateRow');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($values);
        }
    }

    /**
     * @param array $response
     *
     * @return mixed
     */
    public function onUpdateFastRowResponse(array &$response)
    {
        $closure = $this->getClosure('onUpdateFastRowResponse');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($response);
        }
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function onInsertRowData(array &$data)
    {
        $closure = $this->getClosure('onInsertRowData');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($data);
        }
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function onUpdateRowData(array &$data)
    {
        $closure = $this->getClosure('onUpdateRowData');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($data);
        }
    }

    /**
     * @param $formField
     * @param $db
     * @param $value
     *
     * @return mixed
     */
    public function onSearchCustomFilter($formField, &$db, $value)
    {
        $closure = $this->getClosure('onSearchCustomFilter');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($formField, $db, $value);
        }
    }

    /**
     * @param $formField
     * @param array $row
     * @param $postfix
     *
     * @return mixed
     */
    public function onGetCustomValue($formField, array &$row, &$postfix)
    {
        $closure = $this->getClosure('onGetCustomValue');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($formField, $row, $postfix);
        }
    }

    /**
     * @param $formField
     * @param array $row
     *
     * @return mixed
     */
    public function onGetCustomEditInput($formField, array &$row)
    {
        $closure = $this->getClosure('onGetCustomEditInput');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($formField, $row);
        }
    }

    /**
     * @param $formField
     * @param array $row
     *
     * @return mixed
     */
    public function onGetCustomListValue($formField, array &$row)
    {
        $closure = $this->getClosure('onGetCustomListValue');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($formField, $row);
        }
    }

    /**
     * @param $db
     *
     * @return mixed
     */
    public function onSelectCustomValue(&$db)
    {
        $closure = $this->getClosure('onSelectCustomValue');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($db);
        }
    }

    /**
     * @param $file
     *
     * @return mixed
     */
    public function onFileUpload($file)
    {
        $closure = $this->getClosure('onFileUpload');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($file);
        }
    }

    /**
     * @param $formField
     * @param $file
     *
     * @return mixed
     */
    public function onPhotoUpload($formField, $file)
    {
        $closure = $this->getClosure('onPhotoUpload');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($formField, $file);
        }
    }

    /**
     * @param $file
     *
     * @return mixed
     */
    public function onPhotoUploadFromWysiwyg($file)
    {
        $closure = $this->getClosure('onPhotoUploadFromWysiwyg');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($file);
        }
    }

    /**
     * @param $def
     *
     * @return mixed
     */
    public function onInsertButtonFetch($def)
    {
        $closure = $this->getClosure('onInsertButtonFetch');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($def);
        }
    }

    /**
     * @param $def
     *
     * @return mixed
     */
    public function onUpdateButtonFetch($def)
    {
        $closure = $this->getClosure('onUpdateButtonFetch');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($def);
        }
    }

    /**
     * @param $def
     *
     * @return mixed
     */
    public function onDeleteButtonFetch($def)
    {
        $closure = $this->getClosure('onDeleteButtonFetch');
        if ($closure) {
            $closure = $closure->bindTo($this);

            return $closure($def);
        }
    }
}
