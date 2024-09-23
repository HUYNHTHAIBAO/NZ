<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YoutubeExpert extends Model
{
    //
    protected $table = 'lck_youtube_expert';
    protected $fillable = [
        'user_expert_id',
        'link',
        'status',
        'image_file_id',
        'image_file_path',
        'title',
    ];

    public function userExpert()
    {
        return $this->belongsTo(CoreUsers::class);
    }
}
