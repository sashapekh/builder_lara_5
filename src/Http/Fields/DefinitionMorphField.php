<?php

namespace Vis\Builder\Fields;


/**
 * Class DefinitionField.
 */
class DefinitionMorphField extends DefinitionField
{
    /**
     * @param $db
     * @param $value
     */
    public function onSearchFilter(&$db, $value)
    {
        $table = $this->definition['db']['table'];
        $db->where($table.'.'.$this->getFieldName(), 'LIKE', '%'.$value.'%');
    }

    /**
     * @param $row
     *
     * @return bool
     */
    public function getListValue($row)
    {
        if ($this->hasCustomHandlerMethod('onGetListValue')) {
            $res = $this->handler->onGetListValue($this, $row);
            if ($res) {
                return $res;
            }
        }
    }

    /**
     * @param $db
     */
    public function onSelectValue(&$db)
    {
    }

    /**
     * @param  string  $ident
     * @param  bool  $default
     *
     * @return bool
     */
    public function getAttribute($ident, $default = false)
    {
        if ($ident == 'hide_list') {
            return true;
        }

        return parent::getAttribute($ident, $default);
    }

    /**
     * @param  array  $row
     *
     * @return string
     * @throws \Throwable
     *
     */
    public function getEditInput($row = [])
    {
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }

        $this->attributes['name'] = $this->getFieldName();
        $this->attributes['table'] = config('builder.tb-definitions.'.$this->getAttribute('definition').'.db.table');


        $input = view('admin::tb.input_definition_morph');
        $input->nameDefinition = $this->getAttribute('definition');
        $input->name = $this->getFieldName();
        $input->table = $this->attributes['table'];

        $input->attributes = json_encode(array_merge($this->attributes, [
            'relationName' => $this->getAttribute('relationName', null),
            'askedModel'   => $this->getMorphClass(),
            'model_id'     => $this->getClassId()
        ]));

        return $input->render();
    }

    /**
     * @throws \Exception
     */
    private function getMorphClass(): string
    {
        $class = $this->options['additional']['current'] ?? null;

        if (!$class) {
            throw new \Exception('Class not found');
        }

        return str_replace('\\', "\\\\", $class->getMorphClass());
    }

    private function getClassId(): ?int
    {
        return (int) $this->options['additional']['node'] ?? null;
    }
}
