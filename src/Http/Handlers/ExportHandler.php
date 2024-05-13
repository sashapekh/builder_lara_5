<?php

namespace Vis\Builder\Handlers;

use Maatwebsite\Excel\Facades\Excel;

/**
 * Class ExportHandler.
 */
class ExportHandler
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
     * @var
     */
    protected $model;

    /**
     * ExportHandler constructor.
     *
     * @param array $exportDefinition
     * @param $controller
     */
    public function __construct(array $exportDefinition, &$controller)
    {
        $this->def = $exportDefinition;
        $this->controller = $controller;
        $this->model = $this->controller->getModel();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function fetch()
    {
        $def = $this->def;
        if (! $this->def || ! $this->def['check']()) {
            return '';
        }

        $fields = [];
        foreach ($this->controller->getFields() as $field) {
            if ($field->getFieldName() == 'password') {
                continue;
            }

            $fields[$field->getFieldName()] = $field->getAttribute('caption');
        }

        if (isset($this->def['handle']['list'])) {
            $listHandler = $this->def['handle']['list'];
            $listHandler($fields);
        }

        return view('admin::tb.export_buttons', compact('def', 'fields'));
    }

    /**
     * @param $type
     */
    public function doExport($type)
    {
        $fieldsCaptions = $this->getFieldsCaptions();
        $fieldsBody = $this->getFieldsBody();

        Excel::create($this->controller->getTable(), function ($excel) use ($fieldsCaptions, $fieldsBody) {
            $excel->sheet('Sheetname', function ($sheet) use ($fieldsCaptions, $fieldsBody) {
                $sheet->row(1, $fieldsCaptions);

                $sheet->row(1, function ($row) {
                    $row->setFontWeight('bold');
                });

                $sheet->rows($fieldsBody);
            });
        })->export($type);
    }

    /**
     * @return array
     */
    private function getFieldsCaptions()
    {
        foreach ($this->controller->getFields() as $field) {
            $fields[$field->getFieldName()] = $field->getAttribute('caption');
        }

        $fields = array_only($fields, array_keys(request('b')));

        return array_values($fields);
    }

    /**
     * @return array
     */
    private function getFieldsBody()
    {
        $between = isset($this->def['date_range_field']) ? $this->getBetweenValues() : [];
        $fields = request('b');

        $rows = $this->controller->query->getRows(false, true, $between, true)->toArray();
        $resultArray = [];

        foreach ($fields as $field => $value) {
            foreach ($rows as $k => $arr) {
                $resultArray[$k][$field] = $this->getValueField($field, $arr);
            }
        }

        return $resultArray;
    }

    /**
     * @param $field
     * @param $collection
     *
     * @return string
     */
    private function getValueField($field, $collection)
    {
        if ($this->checkManyToMany($field)) {
            return $this->getValueManyToMantField($field, $collection['id']);
        }

        $fieldModel = $this->controller->getField($field);

        if ($fieldModel->getAttribute('type') == 'checkbox') {
            return $fieldModel->getValueExport($collection);
        }

        return strip_tags($fieldModel->getListValue($collection), '<a><span><img><br>');
    }

    /**
     * @param $field
     *
     * @return bool
     */
    private function checkManyToMany($field)
    {
        return strpos($field, 'many2many') !== false
            && isset($this->controller->getDefinition()['fields'][$field]);
    }

    /**
     * @param $field
     * @param $id
     *
     * @return string
     */
    private function getValueManyToMantField($field, $id)
    {
        $manyField = $this->controller->getDefinition()['fields'][$field];
        $mtmExternalTable = $manyField['mtm_external_table'];
        $mtmTable = $manyField['mtm_table'];

        $res = (array) \DB::table($mtmTable)
            ->leftJoin(
                $mtmExternalTable,
                "{$mtmExternalTable}.{$manyField['mtm_external_foreign_key_field']}",
                '=',
                "{$mtmTable}.{$manyField['mtm_external_key_field']}"
            )
            ->select("{$mtmExternalTable}.{$manyField['mtm_external_value_field']}")
            ->where("{$mtmTable}.{$manyField['mtm_key_field']}", $id)
            ->pluck("{$manyField['mtm_external_table']}.{$manyField['mtm_external_value_field']}");

        return implode('; ', $res);
    }

    /**
     * @return array
     */
    private function getBetweenValues()
    {
        $dataFilter = request('d');

        $from = $dataFilter['from'] ? $dataFilter['from'].' 00:00:01' : '1900-01-01 00:00:01';
        $to = $dataFilter['to'] ? $dataFilter['to'].' 23:59:59' : date('Y-m-d 23:59:59');

        $table = $this->controller->getDefinition()['db']['table'];

        $field = $this->getAttribute('date_range_field') ?
              $table.'.'.$this->getAttribute('date_range_field')
            : $table.'.created_at';

        return [
            'field'  => $field,
            'values' => [
                $from, $to,
            ],
        ];
    }

    /**
     * @param $ident
     * @param bool $default
     *
     * @return bool|mixed
     */
    private function getAttribute($ident, $default = false)
    {
        return isset($this->def[$ident]) ? $this->def[$ident] : $default;
    }
}
