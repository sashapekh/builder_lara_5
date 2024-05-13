<?php

namespace Vis\Builder;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $table = 'revisions';

    protected $fillable = ['revisionable_type', 'revisionable_id', 'user_id', 'key', 'old_value', 'new_value'];
}
