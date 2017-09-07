<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anniv extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'name', 'desc', 'anniv_at', 'group_id',
    ];

    protected $hidden = [
    ];

    protected $dates = ['deleted_at', 'anniv_at'];

    // Group
}
