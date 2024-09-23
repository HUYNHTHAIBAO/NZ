<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentPostExpert extends Model
{
    //
    protected $table = 'lck_comment_post_expert';
    protected $fillable = [
        'user_id',
        'post_id',
        'content'
    ];

    public function post() {
        return $this->belongsTo(PostExpert::class, 'post_id');
    }

    public function user() {
        return $this->belongsTo(CoreUsers::class, 'user_id', 'id');
    }


}
