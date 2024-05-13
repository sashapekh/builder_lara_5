<?php

namespace Vis\Builder\Handlers;

use Illuminate\Support\Facades\DB;
use Vis\Builder\Exceptions\JarboeValidationException;

/**
 * Class ImportHandler.
 */
class ImportHandler
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
     * ImportHandler constructor.
     *
     * @param array $importDefinition
     * @param $controller
     */
    public function __construct(array $importDefinition, &$controller)
    {
        $this->def = $importDefinition;
        $this->controller = $controller;
    }

    // end __construct

    /**
     * @throws \Throwable
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function fetch()
    {
        $def = $this->def;

        if (isset($def['caption'])) {
            return view('admin::tb.import_buttons', compact('def'));

        // 2 or more buttons
        } else {
            $defArray = $def;
            $html = '';

            foreach ($defArray as $def) {
                $html .= view('admin::tb.import_buttons', compact('def'))->render();
            }

            return $html;
        }
    }

    // end fetch

    /**
     * @param $file
     *
     * @return bool
     */
    public function doImportCsv($file)
    {
        $this->doCheckPermission();

        $definition = $this->controller->getDefinition();
        $table = $definition['db']['table'];

        $delimiter = ',';
        if (isset($this->def['files']['csv']['delimiter'])) {
            $delimiter = $this->def['files']['csv']['delimiter'];
        }

        reset($this->def['fields']);
        $primaryKey = $this->getAttribute('pk', key($this->def['fields']));

        $handle = fopen($file->getRealPath(), 'r');
        $fields = [];
        $n = 1;
        while ($row = fgetcsv($handle, 0, $delimiter)) {
            if ($n === 1) {
                foreach ($row as $key => $rowCaption) {
                    foreach ($this->def['fields'] as $ident => $fieldCaption) {
                        if ($rowCaption === $fieldCaption) {
                            $fields[$key] = $ident;
                        }
                    }
                }
                $n++;
                continue;
            }

            if (count($row) != count($fields)) {
                if (is_null($row[0])) {
                    $message = 'Пустые строки недопустимы для csv формата. Строка #'.$n;
                } else {
                    $message = 'Не верное количество полей. Строка #'.$n.': '
                             .count($row).' из '.count($fields);
                }

                throw new JarboeValidationException($message);
            }

            $updateData = [];
            $pkValue = '';
            foreach ($fields as $key => $ident) {
                if ($ident == $primaryKey) {
                    $pkValue = $row[$key];
                    continue;
                }
                $updateData[$ident] = $row[$key];
            }
            if (! $pkValue) {
                throw new JarboeValidationException('Ключ для обновления не установлен.');
            }

            DB::table($table)->where($primaryKey, $pkValue)->update($updateData);

            $n++;
        }

        return true;
    }

    // end doImportCsv

    public function doCsvTemplateDownload()
    {
        $this->doCheckPermission();

        $delimiter = ',';
        if (isset($this->def['files']['csv']['delimiter'])) {
            $delimiter = $this->def['files']['csv']['delimiter'];
        }

        $csv = '';
        foreach ($this->def['fields'] as $field => $caption) {
            $csv .= '"'.$caption.'"'.$delimiter;
        }
        // remove extra tailing delimiter
        $csv = rtrim($csv, $delimiter);

        $name = $this->getAttribute('filename', 'import_template');
        $this->doSendHeaders($name.'_'.date('Y-m-d').'.csv');

        die($csv);
    }

    // end doCsvTemplateDownload

    /**
     * @param $filename
     */
    private function doSendHeaders($filename)
    {
        // disable caching
        $now = gmdate('D, d M Y H:i:s');
        header('Expires: Tue, 03 Jul 2001 06:00:00 GMT');
        header('Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate');
        header('Last-Modified: '.$now.' GMT');

        // force download
        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/download');

        // disposition / encoding on response body
        header('Content-Disposition: attachment;filename='.$filename);
        header('Content-Transfer-Encoding: binary');
    }

    // end doSendHeaders

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

    // end getAttribute

    private function doCheckPermission()
    {
        if (! $this->def['check']()) {
            throw new \RuntimeException('Import not permitted');
        }
    }

    // end doCheckPermission
}
