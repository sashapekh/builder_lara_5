<?php

namespace Vis\Builder;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Vis\Builder\Facades\Jarboe as JarboeFacade;

/**
 * Class TableAdminController.
 */
class TableAdminController extends Controller
{
    private $urlAdmin = '/admin/';

    /**
     * @return mixed
     */
    public function showTree()
    {
        $controller = JarboeFacade::tree();

        return $controller->handle();
    }

    /**
     * @param $nameTree
     *
     * @return mixed
     */
    public function showTreeOther($nameTree)
    {
        $model = config('builder.'.$nameTree.'_tree.model');
        $nameTree = $nameTree.'_tree';

        $option = [
            'url'      => $this->urlAdmin.$nameTree,
            'def_name' => $nameTree.'/node',
        ];

        $controller = JarboeFacade::tree($model, $option, $nameTree);

        return $controller->handle();
    }

    /**
     * @return mixed
     */
    public function handleTree()
    {
        $controller = JarboeFacade::tree();

        return $controller->process();
    }

    /**
     * @param $nameTree
     *
     * @return mixed
     */
    public function handleTreeOther($nameTree)
    {
        $model = config('builder.'.$nameTree.'_tree.model');
        $nameTree = $nameTree.'_tree';

        $option = [
            'url'      => $this->urlAdmin.$nameTree,
            'def_name' => $nameTree.'/node',
        ];

        $controller = JarboeFacade::tree($model, $option, $nameTree);

        return $controller->process();
    }

    /**
     * @param string $nameTree
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showTreeAll($nameTree)
    {
        $model = config('builder.'.$nameTree.'.model');
        $actions = config('builder.'.$nameTree.'.actions.show');

        if ($actions && $actions['check']() !== true && is_array($actions['check']())) {
            $tree = $model::whereIn('id', $actions['check']())->get()->toHierarchy();
        } else {
            $tree = $model::all()->toHierarchy();
        }

        $idNode = request('node', 1);
        $current = $model::find($idNode);

        $parentIDs = [];
        foreach ($current->getAncestors() as $anc) {
            $parentIDs[] = $anc->id;
        }

        return view('admin::tree.tree', compact('tree', 'parentIDs'));
    }

    /**
     * @param string $page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPage($page)
    {
        $options = [
            'url'      => $this->urlAdmin.$page,
            'def_name' => $page,
        ];

        $table = JarboeFacade::table($options)['showList'];

        return view('admin::table', compact('table'));
    }

    /**
     * @param $page
     *
     * @return mixed
     */
    public function showPagePost($page)
    {
        $options = [
            'url'      => $this->urlAdmin.$page,
            'def_name' => $page,
        ];

        return JarboeFacade::table($options)['showList'];
    }

    /**
     * @param $page
     *
     * @return mixed
     */
    public function handlePage($page)
    {
        $options = [
            'url'      => $this->urlAdmin.$page,
            'def_name' => $page,
        ];

        return JarboeFacade::table($options);
    }

    /**
     * @param $table
     */
    public function fastEditText($table)
    {
        DB::table($table)->where('id', request('pk'))->update([request('name') => request('value')]);
    }

    /**
     * @throws \Throwable
     *
     * @return string
     */
    public function doChangeRelationField()
    {
        $data = json_decode(htmlspecialchars_decode(request('dataFieldJson')));

        $selected = request('selected');

        $db = DB::table($data->foreign_table)
            ->select($data->foreign_value_field)
            ->addSelect($data->foreign_key_field);

        if (isset($data->additional_where)) {
            foreach ($data->additional_where as $key => $opt) {
                if (trim($opt->sign) == 'in') {
                    $db->whereIn($key, $opt->value);
                } elseif (trim($opt->sign) == 'not in') {
                    $db->whereNotIn($key, $opt->value);
                } else {
                    $db->where($key, $opt->sign, $opt->value);
                }
            }
        }

        if (isset($data->relation->foreign_field_filter) && request('id')) {
            $db->where($data->relation->foreign_field_filter, request('id'));
        }

        if (isset($data->orderBy)) {
            foreach ($data->orderBy as $order) {
                if (isset($order->field) && isset($order->type)) {
                    $db->orderBy($order->field, $order->type);
                }
            }
        }

        $res = $db->get();

        $options = [];
        $foreignKey = $data->foreign_key_field;
        $foreignValue = $data->foreign_value_field;
        $options['0'] = 'Без категории';
        foreach ($res as $val) {
            $val = (array) $val;
            $options[$val[$foreignKey]] = $val[$foreignValue];
        }

        return view('admin::tb.foreign_options', compact('options', 'selected'))->render();
    }

    /**
     * @return int|mixed
     */
    public function insertRecordForManyToMany()
    {
        $title = request('title');
        $params = (array) json_decode(request('paramsJson'));

        $record = (array) DB::table($params['mtm_external_table'])
                            ->where($params['mtm_external_value_field'], $title)->first();

        if ($record) {
            return $record['id'];
        }

        return DB::table($params['mtm_external_table'])->insertGetId([
            $params['mtm_external_value_field'] => $title,
        ]);
    }
}
