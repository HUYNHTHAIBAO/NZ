<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotiExpert extends Model
{
    //
    protected $table = 'lck_noti_expert';
    protected $fillable = [
        'user_id',
        'expert_id',
        'note',
    ];


    public function user() {
        return $this->belongsTo(CoreUsers::class, 'user_id', 'id');
    }

    public function expert() {
        return $this->belongsTo(CoreUsers::class, 'expert_id', 'id');
    }


}
