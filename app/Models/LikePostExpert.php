<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikePostExpert extends Model
{
    //
    protected $table = 'lck_like_post_expert';
    protected $fillable = [
      'post_id',
      'user_id',
      'status',
    ];
    public function user() {
        return $this->belongsTo(CoreUsers::class);
    }
    public function postExpert() {
        return $this->belongsTo(PostExpert::class);
    }
}
