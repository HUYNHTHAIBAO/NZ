<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowExpert extends Model
{
    //
    protected $table = 'lck_follow_expert';
    protected $fillable = [
        'user_id',
        'expert_id'
    ];
//    public function expert()
//    {
//        return $this->belongsTo(CoreUsers::class, 'expert_id', 'id');
//    }
//
//    public function user()
//    {
//        return $this->belongsTo(CoreUsers::class, 'user_id', 'id');
//    }
}
