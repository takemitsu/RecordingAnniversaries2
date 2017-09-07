<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'name', 'desc',
    ];

    protected $hidden = [
    ];

    protected $dates = ['deleted_at'];
}
