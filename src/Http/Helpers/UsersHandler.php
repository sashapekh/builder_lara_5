<?php

namespace Vis\Builder\Helpers;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Vis\Builder\Handlers\CustomHandler;

/**
 * Class UsersHandler.
 */
class UsersHandler extends CustomHandler
{
    /**
     * @param $formField
     * @param array $row
     *
     * @return \Illuminate\Contracts\View\View|void
     */
    public function onGetListValue($formField, array &$row)
    {
        if ($formField->getFieldName() == 'activated') {
            $activation = DB::table('activations')->where('user_id', $row['id'])->where('completed', 1)->count();

            if ($activation) {
                return view('admin::tb.input_checkbox_list')->with('is_checked', 1);
            } else {
                return view('admin::tb.input_checkbox_list')->with('is_checked', 0);
            }
        }
    }

    /**
     * @param $formField
     * @param $row
     *
     * @return bool
     */
    public function onAddSelectField($formField, $row)
    {
        if ($formField->getFieldName() == 'activated') {
            return true;
        }
    }

    /**
     * @param $formField
     * @param array $row
     * @param $postfix
     *
     * @return int|void
     */
    public function onGetValue($formField, array &$row, &$postfix)
    {
        if ($formField->getFieldName() == 'activated') {
            if (! isset($row['id'])) {
                return 0;
            }

            $activation = DB::table('activations')->where('user_id', $row['id'])->where('completed', 1)->count();

            return $activation == 0 ? 0 : 1;
        }
    }

    /**
     * @param array $value
     * @param $row
     */
    public function onUpdateRowData(array &$value, $row)
    {
        $password = $value['password'];

        if (isset($row['id'])) {
            if ($value['activated'] == 0) {
                $user = Sentinel::findById($row['id']);
                Activation::remove($user);
            } else {
                $user = Sentinel::findById($row['id']);
                Activation::remove($user);
                $activation = Activation::create($user);
                Activation::complete($user, $activation->code);
            }

            if ($password && $password != 'password') {
                Sentinel::update($user, ['password' => $password]);
            }

            unset($value['activated']);
            unset($value['password']);
        }
    }

    /**
     * @param array $value
     *
     * @return int
     */
    public function onInsertRowData(array &$value)
    {
        $user = Sentinel::register($value);
        if ($value['activated'] != 0) {
            $activation = Activation::create($user);
            Activation::complete($user, $activation->code);
        }

        return $user->id;
    }
}
