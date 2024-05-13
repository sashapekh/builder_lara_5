<?php

namespace Vis\Builder;

use Cartalyst\Sentinel\Users\EloquentUser;
use DB;

/**
 * Class User.
 */
class User extends EloquentUser
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @param array $params
     */
    public function setFillable(array $params)
    {
        $this->fillable = $params;
    }

    /**
     * @param array $imgParam
     *
     * @return mixed|string
     */
    public function getAvatar(array $imgParam)
    {
        $image = $this->picture ?? '/packages/vis/builder/img/blank_avatar.gif';

        return glide($image, $imgParam);
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getIdsTreeAccess()
    {
        return DB::table('role_users')
            ->leftJoin('roles2tree', 'roles2tree.id_role', '=', 'role_users.role_id')
            ->where('user_id', $this->id)
            ->where('id_tree', '!=', null)
            ->select('roles2tree.id_tree')
            ->get();
    }
}
