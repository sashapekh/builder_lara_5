<?php

namespace Vis\Builder\Handlers;

use Vis\Builder\JarboeController;

/**
 * Class CustomHandler.
 */
abstract class CustomHandler
{
    /**
     * @var JarboeController
     */
    protected $controller;

    /**
     * CustomHandler constructor.
     *
     * @param JarboeController $controller
     */
    public function __construct(JarboeController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @param $ident
     *
     * @return mixed
     */
    protected function getOption($ident)
    {
        return $this->controller->getOption($ident);
    }

    public function handle()
    {
    }

    /**
     * @param $formField
     * @param array $row
     * @param $postfix
     */
    public function onGetValue($formField, array &$row, &$postfix)
    {
    }

    /**
     * @param $formField
     * @param $type
     * @param array $row
     * @param $postfix
     */
    public function onGetExportValue($formField, $type, array &$row, &$postfix)
    {
    }

    /**
     * @param $formField
     * @param array $row
     */
    public function onGetEditInput($formField, array &$row)
    {
    }

    /**
     * @param $formField
     * @param array $row
     */
    public function onGetListValue($formField, array &$row)
    {
    }

    /**
     * @param $formField
     * @param $db
     */
    public function onSelectField($formField, &$db)
    {
    }

    /**
     * @param array $filters
     */
    public function onPrepareSearchFilters(array &$filters)
    {
    }

    /**
     * @param $db
     * @param $name
     * @param $value
     */
    public function onSearchFilter(&$db, $name, $value)
    {
    }

    /**
     * @param array $response
     */
    public function onUpdateRowResponse(array &$response)
    {
    }

    /**
     * @param array $response
     */
    public function onInsertRowResponse(array &$response)
    {
    }

    /**
     * @param array $response
     */
    public function onDeleteRowResponse(array &$response)
    {
    }

    /**
     * @param $id
     */
    public function handleDeleteRow($id)
    {
    }

    /**
     * @param $values
     */
    public function handleInsertRow($values)
    {
    }

    /**
     * @param $values
     */
    public function handleUpdateRow($values)
    {
    }

    /**
     * @param array $response
     */
    public function onUpdateFastRowResponse(array &$response)
    {
    }

    /**
     * @param array $data
     */
    public function onInsertRowData(array &$data)
    {
    }

    /**
     * @param array $data
     * @param $row
     */
    public function onUpdateRowData(array &$data, $row)
    {
    }

    /**
     * @param $formField
     * @param $db
     * @param $value
     */
    public function onSearchCustomFilter($formField, &$db, $value)
    {
    }

    /**
     * @param $formField
     * @param array $row
     * @param $postfix
     */
    public function onGetCustomValue($formField, array &$row, &$postfix)
    {
    }

    /**
     * @param $formField
     * @param array $row
     */
    public function onGetCustomEditInput($formField, array &$row)
    {
    }

    /**
     * @param $formField
     * @param array $row
     */
    public function onGetCustomListValue($formField, array &$row)
    {
    }

    /**
     * @param $db
     */
    public function onSelectCustomValue(&$db)
    {
    }

    /**
     * @param $file
     */
    public function onFileUpload($file)
    {
    }

    /**
     * @param $formField
     * @param $file
     */
    public function onPhotoUpload($formField, $file)
    {
    }

    /**
     * @param $file
     */
    public function onPhotoUploadFromWysiwyg($file)
    {
    }

    /**
     * @param $def
     */
    public function onInsertButtonFetch($def)
    {
    }

    /**
     * @param $def
     */
    public function onUpdateButtonFetch($def)
    {
    }

    /**
     * @param $def
     */
    public function onDeleteButtonFetch($def)
    {
    }

    public function onShowHtml()
    {
    }
}
