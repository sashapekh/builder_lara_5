<?php

namespace Vis\Builder;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name', 'slug', 'permissions'];

    public $timestamps = false;
}
