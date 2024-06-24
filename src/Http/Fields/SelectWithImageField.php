<?php

namespace Vis\Builder\Fields;

use Illuminate\Support\Facades\Session;

class SelectWithImageField extends SelectField
{

    public function getFilterInput()
    {
        return '';
    }

    /**
     * @param array $row
     *
     * @throws \Throwable
     *
     * @return string
     */
    public function getEditInput($row = [])
    {
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }

        $table = view('admin::tb.custom.input_select_with_image');
        $table->selected = $this->getValue($row);
        $table->name = $this->getFieldName();
        $table->options = $this->getAttributeCallable('options');
        $table->disabled = $this->getAttribute('disabled');

        $table->action = $this->getAttribute('action');
        $table->readonly_for_edit = $this->getAttribute('readonly_for_edit');

        return $table->render();
    }
}