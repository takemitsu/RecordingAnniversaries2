<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Anniv extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'name', 'desc', 'anniv_at', 'group_id',
    ];

    protected $hidden = [
    ];

    protected $dates = ['deleted_at', 'anniv_at'];

    // Model call 時に追加
    protected $appends = ['days_next'];

    // 次の年月まで後何日か
    public function getDaysNextAttribute()
    {
        $now = Carbon::now()->setTime(0,0,0);
        $anniv_at = $this->anniv_at;
        $anniv_at->year = $now->year;
        $diff = $anniv_at->diffInDays($now, false);

        if($diff > 0) {
            $anniv_at->year = $now->year + 1;
        }

        return $anniv_at->diffInDays($now);
    }

    // Group とは Relation してるよ設定
    public function group() {
        return $this->hasOne('App\Model\Group');
    }
}
