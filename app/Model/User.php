<?php

namespace App\Model;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Uuid;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    // イベント登録
    protected static function boot()
    {
        parent::boot();

        // 作成されるときにUUIDを設定する
        self::creating(function($user)
        {
            if(! $user->uuid) {
                $user->uuid = (string)Uuid::generate(4);
            }
            return true;
        });
    }

    /**
     * モデルのルートキーの名前
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
