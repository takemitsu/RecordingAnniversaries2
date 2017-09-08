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

    // Model call 時に追加
    protected $appends = ['annivs_count'];

    // Anniv とは Relation してるよ設定
    public function annivs() {
        return $this->hasMany('App\Model\Anniv');
    }
    // Anniv のカウントをデフォルトで返す
    public function getAnnivsCountAttribute()
    {
        return $this->annivs()->count();
    }
}
