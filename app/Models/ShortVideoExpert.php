<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortVideoExpert extends Model
{
    //
    protected $table = 'lck_short_video_expert';
    protected $fillable = [
        'user_expert_id',
        'type',
        'link',
        'status',
        'image_file_id',
        'image_file_path',
        'title',
    ];


    public function userExpert() {
        return $this->belongsTo(CoreUsers::class);
    }
}
